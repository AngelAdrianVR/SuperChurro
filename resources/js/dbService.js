const dbName = 'PuroChurroDB';
let dbVersion;
let db;

const initialStores = [
  {
    name: 'products', keyPath: 'id', indexes: [
      { name: 'name', keyPath: 'name', unique: false },
      { name: 'code', keyPath: 'code', unique: false }
    ]
  },
];

function openDatabase() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open(dbName);

    request.onupgradeneeded = event => {
      db = event.target.result;
      dbVersion = db.version;
      initialStores.forEach(store => {
        if (!db.objectStoreNames.contains(store.name)) {
          const objectStore = db.createObjectStore(store.name, { keyPath: store.keyPath });
          store.indexes.forEach(index => {
            objectStore.createIndex(index.name, index.keyPath, { unique: index.unique });
          });
        }
      });
    };

    request.onsuccess = event => {
      db = event.target.result;
      resolve(db);
    };

    request.onerror = event => {
      reject(event.target.errorCode);
      console.error(event.target.error);
    };
  });
}

function ensureObjectStore(storeName, keyPath = 'id', indexes = []) {
  return new Promise((resolve, reject) => {
    if (db.objectStoreNames.contains(storeName)) {
      resolve();
    } else {
      const newVersion = dbVersion + 1;
      db.close();
      const request = indexedDB.open(dbName, newVersion);

      request.onupgradeneeded = event => {
        db = event.target.result;
        dbVersion = newVersion;
        const store = db.createObjectStore(storeName, { keyPath: keyPath });
        indexes.forEach(index => store.createIndex(index.name, index.keyPath, { unique: index.unique || false }));
      };

      request.onsuccess = event => {
        db = event.target.result;
        resolve();
      };

      request.onerror = event => {
        reject(event.target.errorCode);
      };
    }
  });
}

function getAll(storeName) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(storeName, 'readonly');
    const store = transaction.objectStore(storeName);
    const request = store.getAll();

    request.onsuccess = () => {
      resolve(request.result);
    };

    request.onerror = () => {
      reject(request.error);
    };
  });
}

function getItemByAttributes(storeName, attributes) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(storeName, 'readonly');
    const store = transaction.objectStore(storeName);
    const indexKeys = Object.keys(attributes);
    const results = [];

    let completed = 0;
    indexKeys.forEach(key => {
      const index = store.index(key);
      const request = index.getAll(attributes[key]);

      request.onsuccess = () => {
        results.push(...request.result);
        completed++;
        if (completed === indexKeys.length) {
          const uniqueResults = Array.from(new Set(results.map(item => item.id)))
            .map(id => results.find(item => item.id === id));
          resolve(uniqueResults);
        }
      };

      request.onerror = () => {
        reject(request.error);
      };
    });
  });
}

function getItemByPartialAttributes(storeName, attributes) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(storeName, 'readonly');
    const store = transaction.objectStore(storeName);
    const indexKeys = Object.keys(attributes);
    const results = [];

    let completed = 0;

    indexKeys.forEach(key => {
      const index = store.index(key);
      const request = index.getAll();

      request.onsuccess = () => {
        const regex = new RegExp(attributes[key], 'i');
        const matchingItems = request.result.filter(item => regex.test(item[key]));
        results.push(...matchingItems);
        completed++;
        if (completed === indexKeys.length) {
          const uniqueResults = Array.from(new Set(results.map(item => item.id)))
            .map(id => results.find(item => item.id === id));
          resolve(uniqueResults);
        }
      };

      request.onerror = () => {
        reject(request.error);
      };
    });
  });
}

async function addOrUpdateItem(storeName, item) {
  // revisar si el elemento tiene imagen para guardarla tambien
  await prepareImageToStore(item);

  return new Promise((resolve, reject) => {
    const transaction = db.transaction(storeName, 'readwrite');
    const store = transaction.objectStore(storeName);

    const request = store.put(item);

    request.onsuccess = () => {
      resolve();
    };

    request.onerror = () => {
      reject(request.error);
    };
  });
}

function deleteItem(storeName, id) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(storeName, 'readwrite');
    const store = transaction.objectStore(storeName);
    const request = store.delete(id);

    request.onsuccess = () => {
      resolve();
    };

    request.onerror = () => {
      reject(request.error);
    };
  });
}

function deleteObjectStore(storeName) {
  return new Promise((resolve, reject) => {
    if (!db.objectStoreNames.contains(storeName)) {
      resolve();
      return;
    }

    const newVersion = dbVersion + 1;
    db.close();
    const request = indexedDB.open(dbName, newVersion);

    request.onupgradeneeded = event => {
      db = event.target.result;
      db.deleteObjectStore(storeName);
      dbVersion = newVersion;
    };

    request.onsuccess = event => {
      db = event.target.result;
      resolve();
    };

    request.onerror = event => {
      reject(event.target.errorCode);
    };
  });
}

function deleteDatabase() {
  return new Promise((resolve, reject) => {
    closeDatabaseConnection();
    const request = indexedDB.deleteDatabase(dbName);

    request.onsuccess = () => {
      console.log('Base de datos eliminada con éxito.');
      resolve();
    };

    request.onerror = (event) => {
      reject(event.target.error);
    };

    request.onblocked = () => {
      console.warn('Eliminación de la base de datos bloqueada por otra pestaña.');
      // Puedes notificar al usuario aquí o intentar de nuevo después de un tiempo.
    };
  });
}

function clearObjectStore(storeName) {
  return new Promise((resolve, reject) => {
    if (!db.objectStoreNames.contains(storeName)) {
      resolve();
      return;
    }

    const transaction = db.transaction(storeName, 'readwrite');
    const store = transaction.objectStore(storeName);
    const request = store.clear();

    request.onsuccess = () => {
      resolve();
    };

    request.onerror = () => {
      reject(request.error);
    };
  });
}

function tableExists(storeName) {
  return db.objectStoreNames.contains(storeName);
}

async function initializeProducts() {
  await openDatabase();

  // Descarga inicial de productos en servidor
  const response = await axios.get(route('products.get-all-for-indexedDB'));
  const serverProducts = response.data.products;

  const indexedDBProducts = await getAll('products');
  // revisar si hay mas productos en la base de datos del servidor que en indexedDB
  if (indexedDBProducts.length != serverProducts.length) {
    console.log('Sincronizando indexedDB');
    clearObjectStore('products');
    // actualizar BDD local
    addOrUpdateBatchOfItems('products', serverProducts);
    console.log('indexedDB sincronizada!!');
  }
}

async function addOrUpdateBatchOfItems(storeName, items) {
  const promises = items.map((item) => addOrUpdateItem(storeName, item));
  await Promise.all(promises);
}

//**  Funciones privadas  **//
function closeDatabaseConnection() {
  if (db) {
    db.close();
    db = null;
  }
}

// async function prepareImageToStore(item) {
//   if (item.image_url) {
//     const imageResponse = await axios.get(item.image_url, { responseType: 'blob' });
//     const imageBlob = imageResponse.data;
//     item.image = imageBlob;
//   }
// }

async function syncIDBProducts() {
  if (!db) {
    await openDatabase();
  }

  // Descarga inicial de productos en servidor
  const response = await axios.get(route('products.get-all-for-indexedDB'));
  const serverProducts = response.data.products;

  const indexedDBProducts = await getAll('products');

  console.log('Sincronizando productos', new Date().toLocaleTimeString());

  const serverProductMap = new Map();
  serverProducts.forEach(product => serverProductMap.set(product.id, product));

  const productsToAddOrUpdate = [];
  const productsToDelete = [];

  indexedDBProducts.forEach(localProduct => {
    const serverProduct = serverProductMap.get(localProduct.id);

    if (!serverProduct) {
      // Producto local que no existe en el servidor
      productsToDelete.push(localProduct.id);
    } else {
      // Producto existe en ambos lados, comparar propiedades
      if (
        localProduct.name !== serverProduct.name ||
        localProduct.code !== serverProduct.code ||
        localProduct.public_price !== serverProduct.public_price ||
        localProduct.current_stock !== serverProduct.current_stock ||
        localProduct.image_url !== serverProduct.image_url
      ) {
        productsToAddOrUpdate.push(serverProduct);
      }
      serverProductMap.delete(localProduct.id);
    }
  });

  // Agregar los productos que existen en el servidor pero no en IndexedDB
  serverProductMap.forEach(product => {
    productsToAddOrUpdate.push(product);
  });

  // Realizar las actualizaciones en IndexedDB
  await updateLocalProducts(productsToAddOrUpdate, productsToDelete);
}

async function updateLocalProducts(productsToAddOrUpdate, productsToDelete) {
  if (!db) {
    await openDatabase();
  }

  // Preparar las imágenes fuera de la transacción
  for (let product of productsToAddOrUpdate) {
    await prepareImageToStore(product);
  }

  // Ejecutar las operaciones de IndexedDB dentro de una transacción
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(['products'], 'readwrite');
    const store = transaction.objectStore('products');

    // Eliminar productos que ya no están en el servidor
    productsToDelete.forEach(id => {
      store.delete(id);
    });

    // Agregar o actualizar productos
    productsToAddOrUpdate.forEach(product => {
      store.put(product);
    });

    transaction.oncomplete = () => {
      console.log('Sincronización de productos completada', new Date().toLocaleTimeString());
      resolve();
    };

    transaction.onerror = (event) => {
      reject(event.target.error);
    };
  });
}

async function prepareImageToStore(item) {
  if (item.image_url) {
    try {
      const imageResponse = await axios.get(item.image_url, { responseType: 'blob' });
      const imageBlob = imageResponse.data;
      item.image = imageBlob;
    } catch (error) {
      if (error.response && error.response.status === 404) {
        console.warn(`Imagen no encontrada para el producto ${item.id}, continuando sin imagen.`);
      } else {
        console.error(`Error al obtener la imagen para el producto ${item.id}:`, error);
      }
      // No agregar la imagen al item si hay un error
      item.image = null;
    }
  }
}

export {
  openDatabase,
  ensureObjectStore,
  getAll,
  getItemByAttributes,
  getItemByPartialAttributes,
  addOrUpdateItem,
  deleteItem,
  deleteObjectStore,
  deleteDatabase,
  clearObjectStore,
  tableExists,
  initializeProducts,
  addOrUpdateBatchOfItems,
  prepareImageToStore,
  updateLocalProducts,
  syncIDBProducts,
};

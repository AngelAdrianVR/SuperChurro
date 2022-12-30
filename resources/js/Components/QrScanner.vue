<template>
    <SecondaryButton @click="scannWithWebCam">{{ label }}</SecondaryButton>
</template>
<script>
import { Html5Qrcode } from "html5-qrcode";
import SecondaryButton from "@/Components/SecondaryButton.vue"

export default {
    data() {
        return {
            html5QrCode: null,
        }
    },
    components: {
        SecondaryButton,
    },
    props: {
        label: String,
    },
    // mounted() {
    //     this.html5QrCode = new Html5Qrcode("reader");

    //     const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    //     // back camera
    //     this.html5QrCode.start({ facingMode: "environment" }, config, this.qrCodeSuccessCallback);
    // },
    methods: {
        qrCodeSuccessCallback(decodedText, decodedResult) {
            console.log('Text: ', decodedText);
            console.log('Result: ', decodedResult);
        },
        scannWithWebCam() {
            Html5Qrcode.getCameras().then(devices => {
                /**
                 * devices would be an array of objects of type:
                 * { id: "id", label: "label" }
                 */
                if (devices && devices.length) {
                    const html5QrCode = new Html5Qrcode("reader");
                    html5QrCode.start(
                        devices[0].id,
                        {
                            fps: 10,    // Optional, frame per seconds for qr code scanning
                            qrbox: { width: 250, height: 250 }  // Optional, if you want bounded box UI
                        },
                        (decodedText, decodedResult) => {
                            console.log('Text: ', decodedText);
                            console.log('Result: ', decodedResult);
                        },
                        (errorMessage) => {
                            console.log('error message: ', errorMessage);
                        })
                        .catch((err) => {
                            console.log('error while start scanning: ', err);
                        });
                }
            }).catch(err => {
                console.log('Error while trying to get cameras: ', err);
            });
        }
    }
}
</script>
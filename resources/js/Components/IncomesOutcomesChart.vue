<template>
  <div>
    <div
      class="max-w-sm w-full bg-transparent rounded-lg dark:bg-gray-800 p-4 md:p-6"
    >
      <div
        class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3"
      >
        <dl>
          <dt
            class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1"
          >
            Ganancia
          </dt>
          <dd
            class="leading-none text-3xl font-bold text-gray-900 dark:text-white"
          >
            $102,500
          </dd>
        </dl>
        <div>
          <span
            class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300"
          >
            <svg
              class="w-2.5 h-2.5 mr-1.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 10 14"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13V1m0 0L1 5m4-4 4 4"
              />
            </svg>
            Porcentage demargen 23.5%
          </span>
        </div>
      </div>

      <div class="grid grid-cols-2 py-3">
        <dl>
          <dt
            class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1"
          >
            Ingreso
          </dt>
          <dd
            class="leading-none text-xl font-bold text-green-500 dark:text-green-400"
          >
            $23,635
          </dd>
        </dl>
        <dl>
          <dt
            class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1"
          >
            Egreso
          </dt>
          <dd
            class="leading-none text-xl font-bold text-red-600 dark:text-red-500"
          >
            -$18,230
          </dd>
        </dl>
      </div>

      <div id="bar-chart"></div>
      <div
        class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between"
      >
      </div>
    </div>
  </div>
</template>

<script>
import ApexCharts from "apexcharts";

export default {
  data() {
    return {
      options: {
        series: [
          {
            name: "Ingreso",
            color: "#31C48D",
            data: ["9250", "5984", "5250", "9250", "12987", "6774"],
          },
          {
            name: "Egreso",
            data: ["3254", "4157", "7741", "1124", "3365", "2544"],
            color: "#F05252",
          },
        ],
        chart: {
          sparkline: {
            enabled: false,
          },
          type: "bar",
          width: "100%",
          height: 400,
          toolbar: {
            show: false,
          },
        },
        fill: {
          opacity: 1,
        },
        plotOptions: {
          bar: {
            horizontal: true,
            columnWidth: "100%",
            borderRadiusApplication: "end",
            borderRadius: 6,
            dataLabels: {
              position: "top",
            },
          },
        },
        legend: {
          show: true,
          position: "bottom",
        },
        dataLabels: {
          enabled: false,
        },
        tooltip: {
          shared: true,
          intersect: false,
          formatter: function (value) {
            return "$" + value;
          },
        },
        xaxis: {
          labels: {
            show: true,
            style: {
              fontFamily: "Inter, sans-serif",
              cssClass: "text-xs font-normal fill-gray-500 dark:fill-gray-400",
            },
            formatter: function (value) {
              return "$" + value;
            },
          },
          categories: ["Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
          axisTicks: {
            show: false,
          },
          axisBorder: {
            show: false,
          },
        },
        yaxis: {
          labels: {
            show: true,
            style: {
              fontFamily: "Inter, sans-serif",
              cssClass: "text-xs font-normal fill-gray-500 dark:fill-gray-400",
            },
          },
        },
        grid: {
          show: true,
          strokeDashArray: 4,
          padding: {
            left: 2,
            right: 2,
            top: -20,
          },
        },
        fill: {
          opacity: 1,
        },
      },
    };
  },
  mounted() {
    const chart = new ApexCharts(document.getElementById("bar-chart"), this.options);
    chart.render();
  },
};

// ApexCharts options and config
window.addEventListener("load", function () {
  // if(document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
  //   const chart = new ApexCharts(document.getElementById("bar-chart"), options);
  //   chart.render();
  // }
});
</script>
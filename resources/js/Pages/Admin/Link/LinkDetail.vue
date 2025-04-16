<template>
    <AdminLayout>


        <!-- link info -->
        <div
            class="my-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">

            <div class="">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tiêu đề: {{
                    link.title }}</h5>
                <h4 class="text-2xl dark:text-white">
                    Link gốc: <a :href="link.original_url" class="text-blue-500" target="_blank"
                        rel="noopener noreferrer">
                        {{ link.original_url }}
                    </a>
                </h4>

                <h4 class="font-normal text-gray-700 dark:text-gray-400">
                    Link rút gọn: <a class="text-blue-500 " target="_blank" rel="noopener noreferrer"
                        :href="`https://${domain}/${link.short_code}`">
                        https://{{ domain }}/{{ link.short_code }}
                    </a>
                </h4>

                <h4 class="font-normal text-gray-700 dark:text-gray-400">Người tạo: {{link.username}} </h4>
                <h4 class="font-normal text-gray-700 dark:text-gray-400">Thời gian tạo: {{link.created_at_format}}</h4>
                <h4 class="font-normal text-gray-700 dark:text-gray-400">Thời gian hết hạn: {{link.expires_at}}</h4>

                <h4 v-if="link.expired"class="font-normal text-red-700 dark:text-red-400">
                    Trạng thái: Hết hạn
                </h4>

                <h4 v-else class="font-normal text-gray-700 dark:text-gray-400">
                    Trạng thái: {{ link.status ? 'Công khai' : 'Riêng tư' }}
                </h4>




            </div>

            <div>
                <img :src="qrcode" alt="QR Code" />
            </div>
        </div>
        <!-- end link info -->

        <!-- card list -->
        <div class="my-5 flex items-center justify-between">
            <div
                class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 text-center dark:text-white">Tổng lượt
                    truy cập</h5>
                <p class="text-xl text-gray-700 text-center dark:text-gray-400">10</p>
            </div>

            <div
                class="w-full mx-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 text-center dark:text-white">Top hệ điều
                    hành</h5>
                <p class="text-xl text-gray-700 text-center dark:text-gray-400">Ios</p>
            </div>

            <div
                class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 text-center dark:text-white">Quốc gia
                    hàng đầu</h5>
                <p class="text-xl text-gray-700 text-center dark:text-gray-400">Việt Nam</p>
            </div>
        </div>


        <!-- end card list -->

        <!-- nav tab -->

        <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select tab</label>
                <select id="tabs"
                    class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option>Lượt truy cập</option>
                    <option>Hệ điều hành</option>
                    <option>Quốc gia</option>
                </select>
            </div>
            <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse"
                id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                <li class="w-full">
                    <button id="clicks-tab" data-tabs-target="#clicks" type="button" role="tab" aria-controls="clicks"
                        aria-selected="true"
                        class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Lượt
                        truy cập</button>
                </li>
                <li class="w-full">
                    <button id="operating-system-tab" data-tabs-target="#operating-system" type="button" role="tab"
                        aria-controls="operating-system" aria-selected="false"
                        class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Hệ
                        điều hành</button>
                </li>
                <li class="w-full">
                    <button id="nation-tab" data-tabs-target="#nation" type="button" role="tab" aria-controls="nation"
                        aria-selected="false"
                        class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Quốc
                        gia</button>
                </li>
            </ul>
            <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="clicks" role="tabpanel"
                    aria-labelledby="clicks-tab">
                    <!-- chart clicks-->
                    <div v-apex-tooltip-style class="w-full mx-auto bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Thống kê lượt truy cập</h2>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <!-- date picker -->
                            <VueDatePicker v-model="date" range multi-calendars :preset-dates="presetDates" auto-apply
                                locale="vi" :format="format">VueDatePicker>
                                <template #preset-date-range-button="{ label, value, presetDate }">
                                    <span role="button" :tabindex="0" @click="presetDate(value)"
                                        @keyup.enter.prevent="presetDate(value)"
                                        @keyup.space.prevent="presetDate(value)">
                                        {{ label }}
                                    </span>
                                </template>
                            </VueDatePicker>

                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 ml-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Gửi</button>
                        </div>



                        <div class="h-[300px]">
                            <apexchart height="100%" type="bar" :options="chartOptionsBar" :series="seriesBar" />
                        </div>
                    </div>
                </div>

                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="operating-system"
                    role="tabpanel" aria-labelledby="operating-system-tab">
                    <!-- chart opereting system -->
                    <div v-apex-tooltip-style class="w-full mx-auto bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Thống kê hệ điều hành</h2>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <!-- date picker -->
                            <VueDatePicker v-model="date" range multi-calendars :preset-dates="presetDates" auto-apply
                                locale="vi" :format="format">
                                <template #preset-date-range-button="{ label, value, presetDate }">
                                    <span role="button" :tabindex="0" @click="presetDate(value)"
                                        @keyup.enter.prevent="presetDate(value)"
                                        @keyup.space.prevent="presetDate(value)">
                                        {{ label }}
                                    </span>
                                </template>
                            </VueDatePicker>

                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 ml-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Gửi</button>
                        </div>

                        <div class="h-[300px]">
                            <apexchart height="100%" type="area" :options="chartOptions" :series="series" />
                        </div>
                    </div>
                </div>

                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="nation" role="tabpanel"
                    aria-labelledby="nation-tab">
                    <!-- chart nation -->
                    <div v-apex-tooltip-style class="w-full mx-auto bg-white rounded-lg shadow dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Thống kê quốc gia</h2>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <!-- date picker -->
                            <VueDatePicker v-model="date" range multi-calendars :preset-dates="presetDates" auto-apply
                                locale="vi" :format="format">
                                <template #preset-date-range-button="{ label, value, presetDate }">
                                    <span role="button" :tabindex="0" @click="presetDate(value)"
                                        @keyup.enter.prevent="presetDate(value)"
                                        @keyup.space.prevent="presetDate(value)">
                                        {{ label }}
                                    </span>
                                </template>
                            </VueDatePicker>

                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 ml-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Gửi</button>
                        </div>

                        <div class="h-[300px]">
                            <!-- Pie Chart -->
                            <apexchart height="300" type="pie" :options="chartOptionsPie" :series="seriesPie" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end nav tab -->
    </AdminLayout>

</template>

<script setup>
import AdminLayout from '../Components/AdminLayout.vue'
import { ref, onMounted, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { endOfMonth, endOfYear, startOfMonth, startOfYear, subMonths } from 'date-fns';
import { useQRCode } from '@vueuse/integrations/useQRCode'
import { shallowRef } from 'vue';




const date = ref();

onMounted(() => {
  const startDate = new Date();
  const endDate = new Date(new Date().setDate(startDate.getDate() - 7));
  date.value = [startDate, endDate];
})


const presetDates = ref([
  { label: 'Hôm nay', value: [new Date(), new Date()] },
  {
    label: '7 ngày trước',
    value: [new Date(), new Date(new Date().setDate(new Date().getDate() - 7))],
  },
  { label: 'Tháng này',
    value: [startOfMonth(new Date()), endOfMonth(new Date())] },
  {
    label: 'Tháng trước',
    value: [startOfMonth(subMonths(new Date(), 1)), endOfMonth(subMonths(new Date(), 1))],
  },

]);

const format = (dates) => {
  if (!dates || dates.length !== 2) return '';

  const formatDate = (date) => {
    const day = date.getDate().toString().padStart(2, '0');
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
  };

  return `Từ ${formatDate(dates[0])} đến ${formatDate(dates[1])}`;
};

const props = defineProps({
  link: Object
});

const domain = ref(window.location.hostname);

// QR code
const qrcode = useQRCode(`https://${domain.value}/${props.link.short_code}`);




function applyTooltipStyles() {
  const tooltipLabels = document.querySelectorAll('.apexcharts-tooltip-text-y-label');
  const tooltipValues = document.querySelectorAll('.apexcharts-tooltip-text-y-value');
  const tooltipTitles = document.querySelectorAll('.apexcharts-tooltip-title');
  const xaxisTooltips = document.querySelectorAll('.apexcharts-xaxistooltip-text');

  tooltipLabels.forEach(el => {
    el.style.cssText += 'font-size: 13px !important; color: var(--color-gray-500) !important;';
  });

  tooltipValues.forEach(el => {
    el.style.cssText += 'font-size: 13px !important; color: #222 !important;';
  });

  tooltipTitles.forEach(el => {
    el.style.cssText += 'font-size: 14px !important; font-weight: 600 !important; color: #333 !important;';
  });

  xaxisTooltips.forEach(el => {
    el.style.cssText += 'font-size: 13px !important; fill: #fff !important; font-weight: 500 !important;';
  });
}

const chartOptions = ref({
  chart: {
    type: 'area',
    stacked: true,
    fontFamily: "Inter, sans-serif",
    events: {
      updated: function (chartContext, config) {
        console.log("Area Chart (Hệ điều hành) updated");
        applyTooltipStyles();
      }
    }
  },
  xaxis: {
    categories: ['1/4', '2/4', '3/4', '4/4', '5/4', '6/4'], // tháng hoặc mốc thời gian
    title: {
      text: 'Ngày'
    }
  },
  yaxis: {
    title: {
      text: 'clicks'
    },
    style: {
            fontFamily: "Inter, sans-serif",
          },
  },
  tooltip: {
    shared: true,
    intersect: false,
    y: {
      formatter: function (val) {
        return val + ' lượt';
      }
    }
  },
  legend: {
    position: 'top'
  },
  dataLabels: {
    enabled: false
  }
});

const series = ref([
  {
    name: 'PC',
    data: [120, 200, 180, 250, 0, 270]
  },
  {
    name: 'IOS',
    data: [90, 110, 100, 130, 160, 140]
  },
  {
    name: 'ANDROID',
    data: [150, 180, 170, 90, 220, 210]
  }
]);




// ===== PIE CHART =====
const chartOptionsPie = ref({
  labels: ['Sản phẩm A', 'Sản phẩm B', 'Sản phẩm C'],
  tooltip: {
    y: {
      formatter: function (val) {
        return val + ' đơn hàng';
      }
    }
  }
});

const seriesPie = ref([44, 55, 13]);




// ===== BAR CHART =====
const chartOptionsBar = ref({
  chart: {
    type: 'bar',
    events: {
      updated: function (chartContext, config) {
        console.log("Bar Chart updated");
      }
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%'
    }
  },
  xaxis: {
    categories: ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7']
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + ' lượt xem';
      }
    }
  }
});

const seriesBar = ref([
  {
    name: 'Lượt xem',
    data: [120, 200, 150, 300, 123,242 , 122]
  }
]);




















</script>

<style scoped>


.apexcharts-canvas .apexcharts-legend-text {
    font-size: 10px !important;
    color: var(--color-gray-500) !important;
}


.apexcharts-canvas .apexcharts-tooltip .apexcharts-tooltip-text-y-label {
    color: var(--color-gray-500) !important;
    font-size: 10px !important;
}

.apexcharts-canvas .apexcharts-tooltip .apexcharts-tooltip-text-y-value {
    color: var(--color-gray-900);
    font-size: 10px !important;
}

.apexcharts-tooltip-y-group {
    padding: 0;
}
</style>
<template>
    <AdminLayout>


        <!-- link info -->
        <div
            class="my-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">

            <div class="w-full lg:w-2/3">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Tiêu đề: {{ link.title }}
                </h5>
                <h4 class="text-2xl dark:text-white">
                    Link gốc:
                    <a :href="link.original_url" class="text-blue-500" target="_blank" rel="noopener noreferrer">
                        {{ link.original_url }}
                    </a>
                </h4>

                <h4 class="font-normal text-gray-700 dark:text-gray-400">
                    Link rút gọn:
                    <a class="text-blue-500" target="_blank" rel="noopener noreferrer"
                    :href="`https://${domain}/${link.short_code}`">
                        https://{{ domain }}/{{ link.short_code }}
                    </a>
                </h4>

                <h4 class="font-normal text-gray-700 dark:text-gray-400">Người tạo: {{ link.username }}</h4>
                <h4 class="font-normal text-gray-700 dark:text-gray-400">Thời gian tạo: {{ link.created_at_format }}</h4>
                <h4 class="font-normal text-gray-700 dark:text-gray-400">Thời gian hết hạn: {{ link.expires_at }}</h4>

                <h4 v-if="link.expired" class="font-normal text-red-700 dark:text-red-400">
                    Trạng thái: Hết hạn
                </h4>

                <h4 v-else class="font-normal text-gray-700 dark:text-gray-400">
                    Trạng thái: {{ link.status ? 'Công khai' : 'Riêng tư' }}
                </h4>
            </div>

            <div class="w-full lg:w-1/3 flex justify-center lg:justify-end">
                <img :src="qrcode" alt="QR Code" class="max-w-full h-auto" />
            </div>
        </div>

        <!-- end link info -->

        <!-- card list -->
        <div class="my-5 flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div
                class="w-full lg:w-1/3 mb-4 lg:mb-0 p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 text-center dark:text-white">
                    Tổng lượt truy cập
                </h5>
                <p class="text-xl text-gray-700 text-center dark:text-gray-400">{{ link.total_clicks }}</p>
            </div>

            <div
                class="w-full lg:w-1/3 mb-4 lg:mb-0 lg:mx-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 text-center dark:text-white">
                    Top hệ điều hành
                </h5>
                <p class="text-xl text-gray-700 text-center dark:text-gray-400">{{link.top_os}}</p>
            </div>

            <div
                class="w-full lg:w-1/3 p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 text-center dark:text-white">
                    Quốc gia hàng đầu
                </h5>
                <p class="text-xl text-gray-700 text-center dark:text-gray-400">{{ link.top_country }}</p>
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
                    <button id="clicks-tab" @click.prevent="UpdateChart('clicks')" data-tabs-target="#clicks" type="button" role="tab" aria-controls="clicks"
                        aria-selected="true"
                        class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Lượt
                        truy cập</button>
                </li>
                <li class="w-full">
                    <button id="operating-system-tab" @click.prevent="UpdateChart('os')" data-tabs-target="#operating-system" type="button" role="tab"
                        aria-controls="operating-system" aria-selected="false"
                        class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Hệ
                        điều hành</button>
                </li>
                <li class="w-full">
                    <button id="nation-tab" @click.prevent="UpdateChart('country')" data-tabs-target="#nation" type="button" role="tab" aria-controls="nation"
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

                        <div>
                            <form  @submit.prevent="UpdateChart('clicks')">
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

                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 ml-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Chọn</button>
                                </div>
                            </form>
                        </div>


                        <div class="h-[300px]">
                            <!-- <apexchart height="100%" type="bar" :options="chartOptionsBar" :series="seriesBar" /> -->
                            <apexchart height="100%" type="bar" :options="chartOptions" :series="chartSeries" />

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

                        <div>
                            <form  @submit.prevent="UpdateChart('os')">
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

                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 ml-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Chọn</button>
                                </div>
                            </form>
                        </div>

                        <div class="h-[300px]">
                                <apexchart height="100%" type="area" :options="chartOptions" :series="chartSeries" />
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

                        <div>
                            <form  @submit.prevent="UpdateChart('country')">
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

                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 ml-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Chọn</button>
                                </div>
                            </form>
                        </div>


                        <div class="h-[300px]">
                            <!-- Pie Chart -->
                            <apexchart height="300" type="pie" :options="chartOptions" :series="chartSeries"/>
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
import { ref, onMounted, watch, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { endOfMonth, endOfYear, startOfMonth, startOfYear, subMonths } from 'date-fns';
import { useQRCode } from '@vueuse/integrations/useQRCode'


const date = ref();
const chartOptions = ref({});
const chartSeries = ref([]);

onMounted(() => {
    const endDate = new Date();
    const startDate = new Date(new Date().setDate(endDate.getDate() - 7));
    date.value = [startDate, endDate];
    UpdateChart('clicks');
})


const presetDates = ref([
  { label: 'Hôm nay', value: [new Date(), new Date()] },
  {
    label: '7 ngày trước',
    value: [new Date(new Date().setDate(new Date().getDate() - 7)), new Date()],
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



// viết function lấy dữ liệu dùng form submit truyền vào loại chart và ngày bắt đầu ngày kết thúc
const UpdateChart = async (type) => {
    chartOptions.value = {};
    chartSeries.value = [];

    const formData = new FormData();
    formData.append('startDate', date.value[0].toISOString().split('T')[0]);
    formData.append('endDate', date.value[1].toISOString().split('T')[0]);
    formData.append('type', type);
    formData.append('_method', 'GET');


    try {
        await router.post('/admin/links/view/' + props.link.id, formData, {
            preserveScroll: true,
            onSuccess: (page) => {
                const chartData = page.props.link[type];
                let typeChart = 'bar';
                if(type == 'os'){
                    typeChart = 'area';
                } else if(type == 'country'){
                    typeChart = 'pie';
                }

                const { chartOptions: newOptions, series: newSeries } = createChart(typeChart, chartData);
                chartOptions.value = newOptions.value;
                chartSeries.value = newSeries.value;
            },
            onError: (errors) => {
                if (errors) {
                    let errorMessages = Object.values(errors).flat().join('<br>');

                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        position: 'top',
                        showConfirmButton: false,
                        title: 'Đã xảy ra lỗi!',
                        html: errorMessages,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                }
            },
        });
    } catch (e) {
        // console.log(e);
    }
};





function createChart(type, dataObject) {
    const categories = Object.keys(dataObject);

  const commonTooltip = {
    y: {
      formatter: function (val) {
        return val + ' lượt';
      }
    }
  };

  const baseChartOptions = {
    chart: {
      type: type,
      fontFamily: "Inter, sans-serif",
      stacked: type === 'area',
      events: {
        updated: function (chartContext, config) {
        //   console.log(`${type.charAt(0).toUpperCase() + type.slice(1)} Chart updated`);
          applyTooltipStyles();
        }
      }
    },
    tooltip: commonTooltip
  };

  let chartOptions = {};
  let series = [];

  switch (type) {
    case 'bar':
      chartOptions = {
        ...baseChartOptions,
        xaxis: {
          categories: categories.reverse()
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%'
          }
        }
      };
      series = [
        {
            name: 'Lượt truy cập',
          data: Object.values(dataObject).reverse()
        }
      ];
      break;

    case 'area':
      // Tạo danh sách tên hệ điều hành từ giá trị đầu tiên
      const sample = dataObject[categories[0]];
      const osNames = Object.keys(sample);

      // Duyệt qua từng hệ điều hành để tạo series tương ứng
      series = osNames.map(os => ({
            name: os,
            data: categories.map(date => dataObject[date][os] || 0)
        }));


      chartOptions = {
        ...baseChartOptions,
        xaxis: {
          categories: categories,
          title: {
            text: 'Ngày'
          }
        },
        yaxis: {
          title: {
            text: 'Lượt truy cập'
          }
        },
        legend: {
          position: 'top'
        },
        dataLabels: {
          enabled: false
        }
      };
      break;

    case 'pie':
      chartOptions = {
        ...baseChartOptions,
        labels: Object.keys(dataObject)
      };
      series = Object.values(dataObject);

      break;

    default:
      console.error("Unsupported chart type: " + type);
      return null;
  }

  return {
    chartOptions: ref(chartOptions),
    series: ref(series)
  };
}





function applyTooltipStyles() {
    let isDark = false;
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        isDark = true;

    } else {
       isDark = false;
    }

  const textColor = isDark ? 'rgb(129 129 129)' : '#222';
  const labelColor =  'var(--color-gray-500)';
  const titleColor = '#333';

  document.querySelectorAll('.apexcharts-tooltip-text-y-label').forEach(el => {
    el.style.cssText += `font-size:13px!important;color:${labelColor}!important;`;
  });

  document.querySelectorAll('.apexcharts-tooltip-text-y-value').forEach(el => {
    el.style.cssText += `font-size:13px!important;color:#222!important;`;
  });

  document.querySelectorAll('.apexcharts-tooltip-title').forEach(el => {
    el.style.cssText += `font-size:14px!important;font-weight:600!important;color:${titleColor}!important;`;
  });

  document.querySelectorAll('.apexcharts-xaxistooltip-text, .apexcharts-canvas .apexcharts-legend-text').forEach(el => {
    el.style.cssText += `font-size:13px!important;fill:#fff!important;font-weight:500!important; color:${textColor}!important;`;
  });
}
















</script>

<style scoped>


</style>

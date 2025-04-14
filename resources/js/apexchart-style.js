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

  export default {
    mounted() {
    //   setTimeout(() => {
    //     applyTooltipStyles();
    //   }, 500); // Delay 1 chút để ApexChart render xong
    }
  }

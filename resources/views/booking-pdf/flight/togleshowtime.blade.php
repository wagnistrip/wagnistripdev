<!DOCTYPE html>
<html>
<head>
	<title>Flight Booking Confirmation</title>
</head>


            @php
                use App\Http\Controllers\Airline\AirportiatacodesController;
            @endphp 
<body style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="156px" height="125px" style="margin-bottom: -5%; margin-right: 61%;">
    <g><path style="opacity:0.599" fill="#23c64a" d="M 49.5,28.5 C 45.0017,30.8756 40.835,30.2089 37,26.5C 36.7216,27.4158 36.2216,28.0825 35.5,28.5C 34.8333,28.5 34.1667,28.5 33.5,28.5C 34.3503,26.4149 34.6837,24.4149 34.5,22.5C 37.852,23.226 41.1853,24.0593 44.5,25C 46.5844,25.6972 48.2511,26.8639 49.5,28.5 Z"/></g>
    <g><path style="opacity:0.658" fill="#23c649" d="M 15.5,29.5 C 15.5,28.1667 15.5,26.8333 15.5,25.5C 19.2396,25.1432 22.573,23.8099 25.5,21.5C 26.7481,22.0402 27.9148,22.7069 29,23.5C 30.0113,22.6634 31.1779,22.33 32.5,22.5C 32.5,24.1667 32.5,25.8333 32.5,27.5C 27.1792,26.9787 22.1792,27.9787 17.5,30.5C 16.8165,30.1373 16.1499,29.8039 15.5,29.5 Z"/></g>
    <g><path style="opacity:0.629" fill="#23c649" d="M 15.5,29.5 C 15.5852,30.9953 14.9185,31.9953 13.5,32.5C 12.2322,31.5721 10.8989,31.4054 9.5,32C 10.9733,32.7096 11.6399,33.8762 11.5,35.5C 10.1667,35.5 9.5,36.1667 9.5,37.5C 7.80734,38.4749 6.30734,39.8082 5,41.5C 3.59048,40.2125 2.09048,39.0458 0.5,38C 1.90711,36.548 3.40711,36.7147 5,38.5C 5.49224,37.451 5.32557,36.451 4.5,35.5C 5.70371,32.8623 7.37038,30.529 9.5,28.5C 10.9056,29.6682 12.0723,29.3348 13,27.5C 13.4169,28.756 14.2502,29.4226 15.5,29.5 Z"/></g>
    <g><path style="opacity:0.947" fill="#25c54b" d="M 31.5,30.5 C 32.8333,30.5 34.1667,30.5 35.5,30.5C 35.8417,31.3382 36.5084,31.6716 37.5,31.5C 37.8333,31.5 38.1667,31.5 38.5,31.5C 38.8417,32.3382 39.5084,32.6716 40.5,32.5C 41.3678,35.7312 41.3678,39.0645 40.5,42.5C 36.9808,43.0128 34.6475,45.0128 33.5,48.5C 31.8035,47.6364 30.6368,46.3031 30,44.5C 29.6667,42.1667 29.3333,39.8333 29,37.5C 26.7784,35.7219 24.6117,35.5553 22.5,37C 24.6674,38.7589 26.334,40.9255 27.5,43.5C 27.0688,44.2935 26.7355,45.1268 26.5,46C 27.8333,49 29.1667,52 30.5,55C 30.3893,56.7215 29.8893,56.8882 29,55.5C 27.8289,56.8932 26.3289,57.7265 24.5,58C 20.2894,61.7056 20.6227,64.7056 25.5,67C 23.4432,67.3052 21.4432,67.3052 19.5,67C 20.0465,67.9246 20.7132,68.7579 21.5,69.5C 23.3111,68.2643 25.1444,68.2643 27,69.5C 30.0809,71.2909 33.2476,72.9576 36.5,74.5C 33.8333,79.1668 29.8333,81.8334 24.5,82.5C 24.6602,80.8008 24.4935,79.1341 24,77.5C 22.1653,75.5506 20.9986,73.2173 20.5,70.5C 18.7567,68.9617 16.7567,67.9617 14.5,67.5C 10.1469,63.1232 7.64695,57.7898 7,51.5C 6.10723,52.7112 5.2739,52.7112 4.5,51.5C 4.7262,47.8546 6.39286,45.188 9.5,43.5C 10.549,41.472 11.549,39.472 12.5,37.5C 15.9421,37.055 18.6088,35.3883 20.5,32.5C 21.4916,32.6716 22.1583,32.3382 22.5,31.5C 22.8333,31.5 23.1667,31.5 23.5,31.5C 26.3854,31.8064 29.0521,31.4731 31.5,30.5 Z M 21.5,46.5 C 22.2526,52.2936 20.9192,52.9603 17.5,48.5C 18.3202,46.8888 19.6536,46.2222 21.5,46.5 Z M 16.5,63.5 C 20.2998,63.8194 20.4665,64.8194 17,66.5C 16.5172,65.552 16.3505,64.552 16.5,63.5 Z"/></g>
    <g><path style="opacity:0.063" fill="#000f70" d="M 9.5,39.5 C 8.83333,40.1667 8.83333,40.1667 9.5,39.5 Z"/></g>
    <g><path style="opacity:0.063" fill="#000f70" d="M 8.5,40.5 C 7.83333,41.1667 7.83333,41.1667 8.5,40.5 Z"/></g>
    <g><path style="opacity:0.6" fill="#24c54c" d="M 39.5,43.5 C 40.9778,43.238 42.3112,43.5713 43.5,44.5C 41.5365,47.1939 40.2032,46.8606 39.5,43.5 Z"/></g>
    <g><path style="opacity:0.974" fill="#021b6f" d="M 33.5,28.5 C 34.1667,28.5 34.8333,28.5 35.5,28.5C 41.818,30.1603 47.4847,33.1603 52.5,37.5C 52.5,38.1667 52.8333,38.5 53.5,38.5C 63.1993,54.6966 60.8659,68.8632 46.5,81C 43.326,82.7248 39.9927,84.0581 36.5,85C 38.0613,87.7274 39.3946,90.5607 40.5,93.5C 38.8333,93.5 37.1667,93.5 35.5,93.5C 34.8333,92.1667 34.1667,92.1667 33.5,93.5C 31.8333,93.5 30.1667,93.5 28.5,93.5C 29.5017,87.0011 33.1684,82.8344 39.5,81C 42.1059,79.0616 43.9392,76.5616 45,73.5C 46.122,66.5514 46.7887,59.5514 47,52.5C 47.8978,48.2049 49.7311,44.3716 52.5,41C 49.3187,36.918 45.3187,34.0847 40.5,32.5C 40.1583,31.6618 39.4916,31.3284 38.5,31.5C 38.1667,31.5 37.8333,31.5 37.5,31.5C 37.1583,30.6618 36.4916,30.3284 35.5,30.5C 34.1667,30.5 32.8333,30.5 31.5,30.5C 28.6146,30.1936 25.9479,30.5269 23.5,31.5C 23.1667,31.5 22.8333,31.5 22.5,31.5C 21.5084,31.3284 20.8417,31.6618 20.5,32.5C 17.2957,33.3833 14.6291,35.0499 12.5,37.5C 11.5,38.1667 10.5,38.8333 9.5,39.5C 9.5,38.8333 9.5,38.1667 9.5,37.5C 10.5,37.1667 11.1667,36.5 11.5,35.5C 18.0273,30.7692 25.3607,28.4359 33.5,28.5 Z M 52.5,42.5 C 54.4007,47.2254 54.9007,52.2254 54,57.5C 53.4992,52.4918 52.9992,47.4918 52.5,42.5 Z M 20.5,32.5 C 18.6088,35.3883 15.9421,37.055 12.5,37.5C 14.6291,35.0499 17.2957,33.3833 20.5,32.5 Z"/></g>
    <g><path style="opacity:0.541" fill="#24c64a" d="M 49.5,28.5 C 52.1261,29.7624 54.7928,31.0957 57.5,32.5C 56.7176,34.3293 57.3843,35.8293 59.5,37C 58.3909,38.813 59.0576,39.6463 61.5,39.5C 61.3297,42.4905 62.663,44.4905 65.5,45.5C 64.9598,46.7481 64.2931,47.9148 63.5,49C 65.6983,50.67 66.0317,52.67 64.5,55C 65.2401,56.7849 65.9067,58.6183 66.5,60.5C 64.3687,67.7279 61.3687,74.0612 57.5,79.5C 56.0981,79.1345 55.0981,78.3012 54.5,77C 55.735,74.0341 57.0684,71.2007 58.5,68.5C 61.7973,68.6713 62.1306,68.0046 59.5,66.5C 60.2132,64.2241 60.7132,61.8907 61,59.5C 61.5,58.3333 62.3333,57.5 63.5,57C 60.3371,55.2415 60.0037,53.2415 62.5,51C 60.741,49.992 59.5743,48.492 59,46.5C 58.5503,44.481 57.717,42.6477 56.5,41C 56.8333,40.6667 57.1667,40.3333 57.5,40C 56.0993,39.5899 54.766,39.0899 53.5,38.5C 52.8333,38.5 52.5,38.1667 52.5,37.5C 52.264,35.0268 50.9307,33.3601 48.5,32.5C 49.2458,31.2638 49.5792,29.9305 49.5,28.5 Z"/></g>
    <g><path style="opacity:0.443" fill="#01166d" d="M 14.5,67.5 C 14.8844,69.9294 15.551,72.2627 16.5,74.5C 21.1366,74.6077 21.47,75.6077 17.5,77.5C 16.7055,79.4951 16.0388,81.4951 15.5,83.5C 14.8333,83.5 14.5,83.8333 14.5,84.5C 12.8333,83.1667 11.1667,83.1667 9.5,84.5C 8.24119,81.4501 6.24119,78.9501 3.5,77C 4.79323,76.51 6.12656,76.3433 7.5,76.5C 7.5,75.5 7.5,74.5 7.5,73.5C 6.5,73.5 5.5,73.5 4.5,73.5C 4.19081,69.6572 5.69081,68.3239 9,69.5C 10.4443,67.8446 12.2776,67.178 14.5,67.5 Z M 11.5,68.5 C 12.2891,68.7828 12.9558,69.2828 13.5,70C 12.184,70.5281 11.5173,70.0281 11.5,68.5 Z"/></g>
    <g><path style="opacity:0.547" fill="#000000" d="M 155.5,81.5 C 155.5,82.8333 155.5,84.1667 155.5,85.5C 153.833,85.5 152.167,85.5 150.5,85.5C 150.307,81.551 149.807,81.551 149,85.5C 148.691,84.2341 148.191,83.0674 147.5,82C 150.146,81.5026 152.813,81.3359 155.5,81.5 Z"/></g>
    <g><path style="opacity:0.959" fill="#133179" d="M 15.5,83.5 C 16.8775,84.2344 18.3775,84.9011 20,85.5C 20.567,88.1677 21.067,90.8344 21.5,93.5C 20.1667,93.5 18.8333,93.5 17.5,93.5C 17.1667,93.5 16.8333,93.5 16.5,93.5C 13.5,93.5 10.5,93.5 7.5,93.5C 6.34281,90.7273 5.67615,87.7273 5.5,84.5C 6.83333,84.5 8.16667,84.5 9.5,84.5C 10.3267,87.1317 11.16,89.7983 12,92.5C 12.9406,89.846 13.7739,87.1794 14.5,84.5C 14.5,83.8333 14.8333,83.5 15.5,83.5 Z"/></g>
    <g><path style="opacity:0.973" fill="#14327a" d="M 27.5,93.5 C 25.8333,93.5 24.1667,93.5 22.5,93.5C 22.933,90.8344 23.433,88.1677 24,85.5C 25.9645,84.115 27.7979,84.2816 29.5,86C 28.1328,88.3015 27.4661,90.8015 27.5,93.5 Z"/></g>
    <g><path style="opacity:0.992" fill="#11307a" d="M 70.5,93.5 C 68.901,93.2322 67.5676,93.5655 66.5,94.5C 66.1667,94.5 65.8333,94.5 65.5,94.5C 64.4324,93.5655 63.099,93.2322 61.5,93.5C 61.5,90.5 61.5,87.5 61.5,84.5C 62.8734,84.3433 64.2068,84.51 65.5,85C 67.568,87.6418 69.2347,90.4752 70.5,93.5 Z"/></g>
    <g><path style="opacity:0.075" fill="#1d397d" d="M 76.5,93.5 C 74.8333,93.5 73.1667,93.5 71.5,93.5C 71.5,90.5 71.5,87.5 71.5,84.5C 73.1439,84.2865 74.6439,84.6198 76,85.5C 76.4974,88.146 76.6641,90.8127 76.5,93.5 Z"/></g>
    <g><path style="opacity:0.971" fill="#133079" d="M 132.5,93.5 C 130.833,93.5 129.167,93.5 127.5,93.5C 127.062,92.4937 126.396,92.4937 125.5,93.5C 120.833,93.5 116.167,93.5 111.5,93.5C 111.5,91.8333 111.5,90.1667 111.5,88.5C 109.833,88.5 108.167,88.5 106.5,88.5C 106.5,90.1667 106.5,91.8333 106.5,93.5C 105.167,93.5 103.833,93.5 102.5,93.5C 102.5,91.8333 102.5,90.1667 102.5,88.5C 98.8789,89.3725 95.2122,90.0392 91.5,90.5C 92.8333,91.5 94.1667,92.5 95.5,93.5C 91.9581,93.1872 88.6248,93.5206 85.5,94.5C 84.2101,93.9423 83.3768,92.9423 83,91.5C 82.5357,92.0944 82.369,92.7611 82.5,93.5C 80.8333,93.5 79.1667,93.5 77.5,93.5C 77.5,90.5 77.5,87.5 77.5,84.5C 80.2385,83.9648 82.0718,84.9648 83,87.5C 87.0756,83.966 91.409,83.6326 96,86.5C 96.5,86 97,85.5 97.5,85C 105.833,84.3333 114.167,84.3333 122.5,85C 124.329,85.2735 125.829,86.1068 127,87.5C 127.928,84.9648 129.762,83.9648 132.5,84.5C 132.5,87.5 132.5,90.5 132.5,93.5 Z M 91.5,90.5 C 90.0222,90.762 88.6888,90.4287 87.5,89.5C 88.1667,89.1667 88.8333,88.8333 89.5,88.5C 90.7133,88.7472 91.38,89.4138 91.5,90.5 Z M 116.5,88.5 C 118.167,88.5 119.833,88.5 121.5,88.5C 121.5,89.5 121.5,90.5 121.5,91.5C 119.833,91.5 118.167,91.5 116.5,91.5C 116.5,90.5 116.5,89.5 116.5,88.5 Z"/></g>
    <g><path style="opacity:0.971" fill="#153078" d="M 146.5,94.5 C 142.366,93.5151 138.032,93.1818 133.5,93.5C 133.336,90.8127 133.503,88.146 134,85.5C 138.448,84.0676 142.781,84.401 147,86.5C 149.091,89.413 148.924,92.0797 146.5,94.5 Z M 138.5,88.5 C 139.833,88.5 141.167,88.5 142.5,88.5C 142.5,89.8333 142.5,91.1667 142.5,92.5C 141.167,92.5 139.833,92.5 138.5,92.5C 138.5,91.1667 138.5,89.8333 138.5,88.5 Z"/></g>
    <g><path style="opacity:0.956" fill="#102d77" d="M 47.5,93.5 C 45.8333,93.5 44.1667,93.5 42.5,93.5C 44.4855,85.1737 49.4855,82.6737 57.5,86C 60.3725,88.3707 60.0392,90.2041 56.5,91.5C 52.3887,87.2042 49.3887,87.8708 47.5,93.5 Z"/></g>
    <g><path style="opacity:0.95" fill="#29bc51" d="M 7.5,93.5 C 10.5,93.5 13.5,93.5 16.5,93.5C 15.8333,96.5 15.1667,99.5 14.5,102.5C 12.5,102.5 10.5,102.5 8.5,102.5C 8.49205,99.4552 8.15872,96.4552 7.5,93.5 Z"/></g>
    <g><path style="opacity:0.982" fill="#29bf53" d="M 17.5,93.5 C 18.8333,93.5 20.1667,93.5 21.5,93.5C 21.8333,93.5 22.1667,93.5 22.5,93.5C 24.1667,93.5 25.8333,93.5 27.5,93.5C 27.8333,94.8333 28.1667,94.8333 28.5,93.5C 30.1667,93.5 31.8333,93.5 33.5,93.5C 34.1667,94.8333 34.8333,94.8333 35.5,93.5C 37.1667,93.5 38.8333,93.5 40.5,93.5C 40.9321,94.7095 41.5987,95.7095 42.5,96.5C 42.472,98.5824 43.1387,100.416 44.5,102C 42.5273,102.495 40.5273,102.662 38.5,102.5C 38.5,101.5 38.5,100.5 38.5,99.5C 35.3192,99.0016 32.6525,99.8349 30.5,102C 26.7887,102.825 23.122,102.659 19.5,101.5C 18.5178,98.9044 17.8511,96.2377 17.5,93.5 Z"/></g>
    <g><path style="opacity:0.959" fill="#30b156" d="M 42.5,96.5 C 42.5,95.5 42.5,94.5 42.5,93.5C 44.1667,93.5 45.8333,93.5 47.5,93.5C 48.6885,98.2638 51.3551,99.4305 55.5,97C 54.2068,96.51 52.8734,96.3433 51.5,96.5C 51.5,95.1667 51.5,93.8333 51.5,92.5C 54.5,92.5 57.5,92.5 60.5,92.5C 60.6641,95.1873 60.4974,97.854 60,100.5C 56.0669,102.478 51.9002,102.978 47.5,102C 45.251,100.648 43.5844,98.8151 42.5,96.5 Z"/></g>
    <g><path style="opacity:0.996" fill="#26bd50" d="M 61.5,93.5 C 63.099,93.2322 64.4324,93.5655 65.5,94.5C 65.5,97.1667 65.5,99.8333 65.5,102.5C 64.1667,102.5 62.8333,102.5 61.5,102.5C 61.5,99.5 61.5,96.5 61.5,93.5 Z"/></g>
    <g><path style="opacity:0.995" fill="#2cbe53" d="M 70.5,93.5 C 70.8333,93.5 71.1667,93.5 71.5,93.5C 73.1667,93.5 74.8333,93.5 76.5,93.5C 76.5,96.5 76.5,99.5 76.5,102.5C 74.5,102.5 72.5,102.5 70.5,102.5C 69.7128,99.5923 68.3795,96.9256 66.5,94.5C 67.5676,93.5655 68.901,93.2322 70.5,93.5 Z"/></g>
    <g><path style="opacity:0.977" fill="#29bb51" d="M 77.5,93.5 C 79.1667,93.5 80.8333,93.5 82.5,93.5C 84.8755,95.1008 87.3755,96.7675 90,98.5C 92.0243,98.2005 92.5243,97.3671 91.5,96C 89.4817,95.4954 87.4817,94.9954 85.5,94.5C 88.6248,93.5206 91.9581,93.1872 95.5,93.5C 98.0336,96.1423 98.0336,98.9757 95.5,102C 92.1667,102.667 88.8333,102.667 85.5,102C 84.3333,101.5 83.5,100.667 83,99.5C 82.5172,100.448 82.3505,101.448 82.5,102.5C 80.8333,102.5 79.1667,102.5 77.5,102.5C 77.5,99.5 77.5,96.5 77.5,93.5 Z"/></g>
    <g><path style="opacity:0.942" fill="#26bd50" d="M 102.5,93.5 C 103.833,93.5 105.167,93.5 106.5,93.5C 106.5,96.5 106.5,99.5 106.5,102.5C 105.167,102.5 103.833,102.5 102.5,102.5C 102.5,99.5 102.5,96.5 102.5,93.5 Z"/></g>
    <g><path style="opacity:0.979" fill="#28ba52" d="M 111.5,93.5 C 116.167,93.5 120.833,93.5 125.5,93.5C 124.46,95.7194 124.96,97.7194 127,99.5C 127.495,97.5273 127.662,95.5273 127.5,93.5C 129.167,93.5 130.833,93.5 132.5,93.5C 132.5,96.5 132.5,99.5 132.5,102.5C 129.15,102.665 125.817,102.498 122.5,102C 120.994,99.6667 119.327,97.5 117.5,95.5C 116.526,97.7427 116.192,100.076 116.5,102.5C 114.833,102.5 113.167,102.5 111.5,102.5C 111.5,99.5 111.5,96.5 111.5,93.5 Z"/></g>
    <g><path style="opacity:0.979" fill="#2fbd52" d="M 133.5,93.5 C 138.032,93.1818 142.366,93.5151 146.5,94.5C 144.162,96.0395 141.495,96.7062 138.5,96.5C 138.5,98.5 138.5,100.5 138.5,102.5C 136.833,102.5 135.167,102.5 133.5,102.5C 133.5,99.5 133.5,96.5 133.5,93.5 Z"/></g>
    </svg>
    
	<p><strong>Wagnistrip Booking Id:</strong> {{ $bookings->booking_id }} </p>
	<p><strong>Status:</strong> Confirmed</p>
  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
      @foreach (json_decode($bookings->itinerary) as $itinerary)@endforeach
        @php
            $fristcity = json_decode($bookings->itinerary)[0]->DepartCityName ?? json_decode($bookings->itinerary)->DepartCityName ?? '';
            $lastcity = json_decode($bookings->itinerary)[count(json_decode($bookings->itinerary))-1]->ArrivalCityName ?? json_decode($bookings->itinerary)->ArrivalCityName ?? '';
        @endphp
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">WED, 09 DEC '20</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">{{ $itinerary->DepartCityName??'' }} To {{ $itinerary->ArrivalCityName??'' }}</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">2h 30m</th>
    </tr>
  </table>
                       
                        
	  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Passenger Name</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Airline Sector</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Airline PNR</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Seat</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Food</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Insurence</th>
		</tr>
		   @php
                $itinerarys = json_decode($bookings->itinerary);
           @endphp
           
		 @foreach (json_decode($bookings->passenger) as $passenger)
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">{{ ($passenger->Title??'') . ' ' . $passenger->FirstName . ' ' . $passenger->LastName }}
			<small style="font-size: 12px;">({{ $passenger->PaxTypeCode }})</small></th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">{{ ($itinerary->DepartAirportCode??'') . ' - ' . $itinerary->ArrivalAirportCode}}</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">{{ $bookings->airline_pnr }}</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">NA</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">NA</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">NA</th>
		</tr>
		@endforeach
	</table>
	<!--<h2 style="color: #125cb8; margin-top: 30px;">Flight Details</h2>-->
	<h2 style="color: #125cb8; margin-top: 30px;">Itinerary and Reservation Details</h2>
	  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
	                   @php
                            $itinerarys = json_decode($bookings->itinerary);
                    @endphp 
                    
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Airline</th>
		{{--<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Flight No.</th>--}}
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Departure</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Arrival</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Duration</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Class</th>
		</tr>
		<tr>
		    @foreach (json_decode($bookings->itinerary) as $itinerary)
		    {{--{{dd(json_decode($bookings->itinerary))}}--}}
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">
			    <img src="{{ asset('assets/images/flight/' . $itinerary->AirLineCode??'') }}.png" alt="{{ $itinerary->AirLineCode??'' }}">
			   <p>{{ ($itinerary->AirLineCode??'') . ' - ' . $itinerary->FlightNumber??'' }}</p>
			   </th>
		{{--<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;"></th>--}}
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">{{ $itinerary->DepartCityName??'' }}
			<p style="font-size: 12px;">Terminal {{ $itinerary->DepartTerminal??'' }}</p>
			
		{{--<p>{{  getDate_fn($itinerary->DepartDate)??'' ?? date('d-m-Y', strtotime($itinerary->DepartDate))??'' }} |
                                            {{ date('H:i', strtotime($itinerary->ArrivalDateTime)) }}
			</p>--}}
			<p class="small m-0">{{ $itinerary->DepartAirportName??'' }}</p>
			</th>
			
			</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">{{ AirportiatacodesController::getCity($lastcity)}}
			<p style="font-size: 12px;">Terminal {{ $itinerary->ArrivalTerminal }}</p>
			<p style="small m-0">Terminal {{ $itinerary->ArrivalTerminal }}</p>
			</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">2h 30m</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Economy</th>
		</tr>
		@endforeach
	</table>
	
  <h2 style="color: #125cb8; margin-top: 30px;">Fare Details</h2> <p style="margin-left: 52%;">*all price in INR</p>
    <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
     
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Base Fare</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">6580</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Fee & Surcharges</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">0</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Total Fee & Surcharges :</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">897</th>
    </tr>
    
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Charity</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;"> 0</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">TOTAL AMOUNT</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">7477</th>
    </tr>
  </table>
	<h2 style="color: #125cb8; margin-top: 30px;">Important Information</h2>
	<ul style="width: 70%; margin: 0; padding: 0">
		<li>Web Check-in : Web Check-in is now a mandatory step for your air travel. For a hassle-free Web Check-in on Goibibo, please click <a href="#">Here</a></li>
		<li>Check-in Time : Passenger to report 2 hours before departure. Check-in procedure and baggage drop will close 1 hour before departure.</li>
    <li>Valid ID proof needed : Please carry a valid Passport and Visa (mandatory for international travel). Passport should have at least 6 
    months of validity at the time of travel</li>
   <li>DGCA passenger charter : Please refer to passenger charter by clicking <a href="#">Here</a> </li> 
   <li>Beware of fraudsters : Please do not share your personal banking and security details like passwords, CVV, etc. with any third person 
    or party claiming to represent Goibibo. For any query, please reach out to Goibibo on our official customer care number.</li>
    <li>You have paid: INR 4,161 </li>
    
    <li>Gosafe-certified Airport Cabs : Enjoy smooth airport transfers in sanitized cabs with trained drivers. No waiting and no surge pricing! 
      <a href="#">Book : here</a></li>
  </ul>
	<h1>Baggage Information</h1>
	<h2 style="color: #125cb8; margin-top: 30px;">Airline Support</h2>
	  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Airline</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Phone</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Indigo Airlines</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">9910383838</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Wagnistrip Support</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">08069145571 (for all major operators)</th>
		</tr>
	</table>
	<h2 style="color: #125cb8; margin-top: 30px;">GOP-HYD Date Change Charges</h2>
	  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Type</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Condition</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Airline</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Wagnistrip Pvt Ltd</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">3 days - 365 days</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">2500</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">500</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">2 hrs - 3 days</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">3000</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">500</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">0 hrs - 2 hrs</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Non-Changeable</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;"></th>
		</tr>
	</table>
	<h2 style="color: #125cb8; margin-top: 30px;">GOP-HYD Cancellation Charges</h2>
	  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Type</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Condition</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Airline</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Wagnistrip Pvt Ltd</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">3 days - 365 days</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">3000</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">500</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">2 hrs - 3 days</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">3500</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">500</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">0 hrs - 2 hrs</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Non-Refundable</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;"></th>
		</tr>
	</table>
	<h2 style="color: #125cb8; margin-top: 30px;">Baggage Allowance</h2>
	  <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Type</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Sector</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Cabin</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Allowance</th>
		</tr>
		<tr>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Adult</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">GOP-HYD</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">7 Kgs</th>
			<th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">15 Kgs</th>
		</tr>
	</table>
  <h2 style="color: #125cb8; margin-top: 30px;">Baggage Tag</h2>
    <table style="border-collapse: collapse; margin-bottom: 30px;width: 70%;">
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Origin</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Gorakhpur</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Date of Travel</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">09 DEC 2020</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Count of Bag</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">1 of 2</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Flight Number</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">6E - 6318</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Total Pcs of Baggage</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">1</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">PNR</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">AJKPQJ</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Name</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">MR. NEELESH KUMAR</th>
    </tr>
    <tr>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Destination</th>
      <th style="border: 1px solid #e9d6d6;	padding: 10px; text-align: left;">Hyderabad</th>
    </tr>
  </table>
</body>
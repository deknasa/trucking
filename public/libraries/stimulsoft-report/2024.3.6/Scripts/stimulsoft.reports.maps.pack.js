/*
Stimulsoft.Reports.JS
Version: 2024.3.6
Build date: 2024.09.19
License: https://www.stimulsoft.com/en/licensing/reports
*/
!function(f){var b;"object"==typeof exports&&"undefined"!=typeof module?module.exports=(b=require("./stimulsoft.reports.engine.pack"),Object.assign(b,f(b.Stimulsoft))):"function"==typeof define&&define.amd?define(["./stimulsoft.reports.engine.pack"],b=>Object.assign(b,f(b.Stimulsoft))):Object.assign(window,f(window.Stimulsoft))}(function(b){var f={Stimulsoft:b||{}};return b&&"2024.3.6"!==b.__engineVersion&&console.warn("Scripts versions mismatch: engine ver. = %s; maps ver. = 2024.3.6",b.__engineVersion),
,f.Stimulsoft.decodePackedData&&(Object.assign(f,f.Stimulsoft.decodePackedData(f.Stimulsoft.mapsScript)(f.Stimulsoft)),delete f.Stimulsoft.mapsScript),f});
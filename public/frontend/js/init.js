var config = {
  '.chosen-select'           : { search_contains: true },
  '.chosen-select-deselect'  : { allow_single_deselect: true },
  '.chosen-select-no-single' : { disable_search_threshold: 10 },
  '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
  '.chosen-select-rtl'       : { rtl: true },
  '.chosen-select-width'     : { width: '95%' }
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
var config = {
  '.chosen-select2'           : { search_contains: true },
  '.chosen-select-deselect'  : { allow_single_deselect2: true },
  '.chosen-select-no-single' : { disable_search_threshold2: 10 },
  '.chosen-select-no-results': { no_results_text2: 'Oops, nothing found!' },
  '.chosen-select-rtl'       : { rtl: true },
  '.chosen-select-width'     : { width: '95%' }
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}

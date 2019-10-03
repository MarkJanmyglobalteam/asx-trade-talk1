asxTradeTalkApp

.filter('strLimit', function($filter) {
   return function(input, limit) {
      if (! input) return;
      if (input.length <= limit) {
          return input;
      }

      return $filter('limitTo')(input, limit) + '...';
   };
})

.filter('trustAsHtml', function($sce) {
  return function(html) {
    return $sce.trustAsHtml(html);
  };
})
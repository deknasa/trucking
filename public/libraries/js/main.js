
var startTime = Date.now();

function formatUang(nilai){
    var p=/(\d+)(\d{3})/;
    while(p.test(nilai)){
        nilai=nilai.replace(p,"$1"+","+"$2");
    }
    return nilai;
}

function nl2br(str) {
  var break_tag = '<br>';
  return (str + '').replace(/([^>rn]?)(rn|nr|r|n)/g, '' + break_tag + '');
}
<script>
jQuery(document).ready(function () {
    jQuery('#vmap').vectorMap({
      map: 'usa_en',
      enableZoom: true,
      showTooltip: true,
      selectedColor: null,
      hoverColor: null,
      backgroundColor: '#fffff',
      colors: {
        fl: '#016ea1',
        ma: '#016ea1',
        md: '#016ea1',  
        wa: '#016ea1',
        mn: '#016ea1',
        ny: '#016ea1',
        wi: '#016ea1',
        hi: '#016ea1',
        vt: '#016ea1',
        nv: '#016ea1',
        ia: '#016ea1',
        ca: '#016ea1',
        or: '#016ea1',
        nj: '#016ea1',
      },
onRegionClick: function(element, code, region)
{
        window.location = 'http://google.com/' + region;

},
            onLabelShow: function(event, label, code) {
                if (states.toLowerCase().indexOf(code) <= -1) {
                    event.preventDefault();
                } else if (label[0].innerHTML == "Colorado") {
                    label[0].innerHTML = label[0].innerHTML + " - The state where I live!!";
                }
            },
    });
  });
  </script>
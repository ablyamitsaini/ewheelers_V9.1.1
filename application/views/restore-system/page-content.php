<style>.-fixed-wrap{
  position: fixed;
  bottom: 1rem;
  left: 1rem;
  z-index: 9999;
}
.-fixed-wrap a{
  position: relative;
  display: inline-block;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  border: none;
  border-radius: 2px;
  padding: 2.25rem 1rem 0.5rem;
  vertical-align: middle;
  -webkit-border-radius: 5px;
  border-radius: 5px;
  text-align: center;
  text-overflow: ellipsis;
  text-transform: uppercase;
  color: #fff;
  background: #666;
  text-decoration: none;
  font-size: 2rem;
  letter-spacing: 0.15em;
  overflow: hidden;
  min-width:200px;
}
.-fixed-wrap a small{
  position: absolute;
  top: 0;
  left: 0; right: 0;
  display: block;
  padding: 0.5rem 1rem;
  font-size: 0.75rem;
  letter-spacing: 0.05em;
  white-space: nowrap;
  background-color: rgba(0,0,0,0.2);
}</style>
<div class="-fixed-wrap">
  <a href="javascript:void(0)" onClick="showRestorePopup()">
    <small>Database Will Restore in</small>
    <span id="restoreCounter">00:00:00</span>
  </a>
</div>
<script>
<?php
$dateTime = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' +2 hours'));
$restoreTime = FatApp::getConfig('CONF_RESTORE_SCHEDULE_TIME', FatUtility::VAR_STRING, $dateTime);
?>
// Set the date we're counting down to
var countDownDate = new Date('<?php echo $restoreTime;?>').getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    var str  = ('0' + hours).slice(-2) + ":" + ('0' + minutes).slice(-2) + ":" + ('0' + seconds).slice(-2);
    // Display the result in the element with id="demo"
    $('#restoreCounter').html(str);

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        $('#restoreCounter').html("Process...");
        showRestorePopup();
        restoreSystem();
    }
}, 1000);
function showRestorePopup(){
    $.facebox(function() {
        fcom.ajax(fcom.makeUrl('RestoreSystem','customMessage'), '' ,function(ans){
            $.facebox(ans,'catalog-bg"');
        });
    });
}

function restoreSystem(){
    $.mbsmessage('Restore is in process..',false,'alert--process alert');
    fcom.updateWithAjax(fcom.makeUrl('RestoreSystem','index'), '', function(resp){
        setTimeout(function(){ window.location.reload(); }, 3000);
    },false,false);
}
</script>

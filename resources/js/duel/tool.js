// tool_idがこのサイトのdiscordサーバーならURLを自動セット
function setToolCodeToThisSiteDiscord(){
  if($("#tool_id").val() == 1) {
    $("#tool_code").val('https://discord.gg/RGSYqAQJHM');
  }else{
    $("#tool_code").val('');
  }
}

$('#tool_id').change(function () {
  setToolCodeToThisSiteDiscord()
});

// 読み込み時にチェック
$(function () {
  setToolCodeToThisSiteDiscord()
});


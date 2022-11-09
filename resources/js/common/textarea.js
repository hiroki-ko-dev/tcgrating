// 読み込まれた時
$(document).ready( function() {
  $('textarea').each(function(index,val){
    console.log(val.scrollHeight);
    if(val.scrollHeight > 200){
      this.style.height = val.scrollHeight+"px"
    }else{
      this.style.height = 200
    }
  })
});

// 値が変更された時
document.querySelectorAll('textarea').forEach(function(){
  this.addEventListener('keyup',function(e){
    if(e.srcElement.scrollHeight > 200){
      e.srcElement.style.height = e.srcElement.scrollHeight+"px"
    }else{
      e.srcElement.style.height = 200
    }
  })
});

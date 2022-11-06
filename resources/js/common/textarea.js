// 読み込まれた時
// $(document).ready( function() {
//   let textarea = document.querySelector('textarea');
//   textarea.height = e.scrollHeight+"px"
// });

// 値が変更された時
document.querySelectorAll('textarea').forEach(function(){
  this.addEventListener('keyup',function(e){
    e.srcElement.style.height = e.srcElement.scrollHeight+"px"
  })
});

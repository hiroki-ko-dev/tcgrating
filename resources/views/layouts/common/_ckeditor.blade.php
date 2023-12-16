<script>
  // ClassicEditor
  //   .create( document.querySelector( '#editor' ) )
  //   .catch( error => {
  //     console.error( error );
  //   } );

  CKEDITOR.replace('editor', {
    contentsCss: [
      '/build/assets/blog-show.css',
    ],
    filebrowserUploadMethod: 'POST',
    filebrowserUploadUrl: "{{ route('images.upload.ckeditor', ['_token' => csrf_token() ]) }}",
    stylesSet: [

      // コンテナ用のスタイル
      {
        name: 'Row Container',
        element: 'div',
        attributes: { 'class': 'row' }
      },
      // 列用のスタイル
      {
        name: 'Column (1/2)',
        element: 'div',
        attributes: { 'class': 'col-md-6' }
      },
      {
        name: 'Column (1/3)',
        element: 'div',
        attributes: { 'class': 'col-md-4' }
      },
      {
        name: 'Column (1/4)',
        element: 'div',
        attributes: { 'class': 'col-md-3' }
      },
      { name: 'Card Image', element: 'div', attributes: { class: 'card-image' } },

      { name: 'Blue Title', element: 'h3', styles: { 'color': 'Blue' } },
      { name: 'Red Title', element: 'h3', styles: { 'color': 'Red' } },

      // Object Styles
      { name: 'effect', element: 'div', attributes: { class: 'effect' },
        styles: {
            color: '#000000',
            background: '#dcdcdc',
            border: 'solid 2px #000000',
            padding: '5px'
        },
      },
    ],
    on: {
      instanceReady: function(evt) {
        this.dataProcessor.htmlFilter.addRules({
          elements: {
            img: function(el) {
              // 画像要素からstyle属性を削除
              el.attributes.style = '';
            }
          }
        });
      }
    }
  });


</script>

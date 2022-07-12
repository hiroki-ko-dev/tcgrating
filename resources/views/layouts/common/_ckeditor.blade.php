<script>
  // ClassicEditor
  //   .create( document.querySelector( '#editor' ) )
  //   .catch( error => {
  //     console.error( error );
  //   } );

  CKEDITOR.replace('editor', {
    contentsCss: [
      '/css/blog/show.css',
    ],
    stylesSet: [
      { name: 'Big',              element: 'big' },
      { name: 'Small',            element: 'small' },
      { name: 'Typewriter',       element: 'tt' },

      { name: 'Blue Title',       element: 'h3',      styles: { 'color': 'Blue' } },
      { name: 'Red Title',        element: 'h3',      styles: { 'color': 'Red' } },

      // Inline Styles
      { name: 'Marker: Yellow',   element: 'span',    styles: { 'background-color': 'Yellow' } },
      { name: 'Marker: Green',    element: 'span',    styles: { 'background-color': 'Lime' } },

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
  });


</script>

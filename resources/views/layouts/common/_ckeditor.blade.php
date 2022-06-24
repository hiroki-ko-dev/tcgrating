<script>
  // ClassicEditor
  //   .create( document.querySelector( '#editor' ) )
  //   .catch( error => {
  //     console.error( error );
  //   } );

  CKEDITOR.replace('editor', {
    contentsCss: [
      '/css/blog/show.css'
    ]
  });

  // CKEDITOR.stylesSet.add( 'default', [
  //   // Block Styles
  //   { name: 'List', element: 'span',  styles: { 'border': 'solid 1px #000000', 'background': '#E6E6E6', 'padding': '0.5em 3em', 'margin': '1em 0' }},
  // //   // { name: 'List',       element: 'h3',      styles: { 'color': 'Blue' }, attributes: { class: 'some-class' }},
  // //   // { name: 'Red Title',        element: 'h3',      styles: { 'color': 'Red' }, attributes: { class: 'some-class' }},
  // //   //
  // //   // // Inline Styles
  // //   // { name: 'Marker: Yellow',   element: 'span',    styles: { 'background-color': 'Yellow' } },
  // //   // { name: 'Marker: Green',    element: 'span',    styles: { 'background-color': 'Lime' } },
  // //   //
  // //   // Object Styles
  // //   // {
  // //   //   name: 'Image on Left',
  // //   //   element: 'img',
  // //   //   attributes: {
  // //   //     style: 'padding: 5px; margin-right: 5px',
  // //   //     border: '2',
  // //   //     align: 'left'
  // //   //   }
  // //   // }
  // ] );
</script>

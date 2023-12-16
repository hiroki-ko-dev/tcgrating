import React, { useEffect, useRef } from 'react';
import ReactDOM from 'react-dom';
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

import ClassicEditorBase from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import { Alignment } from '@ckeditor/ckeditor5-alignment';  // Importing the package.
import SourceEditing from '@ckeditor/ckeditor5-source-editing/src/sourceediting';
import { Bold, Code, Italic, Strikethrough, Subscript, Superscript, Underline } from '@ckeditor/ckeditor5-basic-styles';

export default class ClassicEditor extends ClassicEditorBase {}

// 使用するプラグインを追加
ClassicEditor.builtinPlugins = [
    Alignment,  // Adding the package to the list of plugins.
    SourceEditing,
    Bold, Italic, Underline, Strikethrough, Code, Subscript, Superscript
    // ここに他の必要なプラグインを追加
];

// デフォルトのエディタ設定
ClassicEditor.defaultConfig = {
  toolbar: {
    items: [
      'alignment',  // Displaying the proper UI element in the toolbar.
      'sourceEditing', // Source Editing ツールを追加
      'bold', 'italic', 'underline', 'strikethrough', 'code', 'subscript', 'superscript'
    ]
  },
  // その他のエディタ設定...
};

// CKEditor React コンポーネント
const CKEditor = () => {
  
  const editorRef = useRef<HTMLDivElement>(null);
  useEffect(() => {
    let editorInstance: ClassicEditor;

      if (editorRef.current) {
        ClassicEditor
          .create(editorRef.current)
          .then(editor => {
              editorInstance = editor;
              editor.model.document.on('change:data', () => {
                  const hiddenEditor = document.getElementById('hidden-editor') as HTMLTextAreaElement;
                  if (hiddenEditor) {
                      hiddenEditor.value = editor.getData();
                }
              });
          })
          .catch(error => {
              console.error('There was a problem initializing the editor:', error);
          });
      }

      return () => {
        if (editorInstance) {
            editorInstance.destroy().catch(error => {
                console.error('There was a problem destroying the editor:', error);
            });
        }
      };
  }, []);

  return <div ref={editorRef} style={{ height: '500px' }}></div>;
}

ReactDOM.render(
<CKEditor />,
  document.getElementById('editor')
);

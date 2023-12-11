import React, { useRef, useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import { Header } from './Header';
import { Content } from './Content';
import html2canvas from 'html2canvas';

const App = () => {
  const resumeJson = JSON.parse(document.getElementById('resumeJson').value);
  const contentRef = useRef(null);
  const [image, setImage] = useState(null);

  useEffect(() => {
    if (resumeJson) {
      const captureContent = async () => {
        const canvas = await html2canvas(contentRef.current);
        const imageSrc = canvas.toDataURL('image/png');
        setImage(imageSrc);
      };

      captureContent();
    }
  }, []);


  return (
    resumeJson ? 
    <div>
      <div className="d-flex flex-row align-items-center p-2">
        <Header resumeJson={resumeJson} />
      </div>
      {!image && (
        <div ref={contentRef}>
          <Content resumeJson={resumeJson} />
        </div>
      )}
      {image && <img src={image} style={{ maxWidth: '100%', height: 'auto' }} alt="Captured content" />}
    </div>
    : <></>
  );
}

ReactDOM.render(
  <App />,
  document.getElementById('target-component')
);

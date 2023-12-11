import React from 'react';
import ReactDOM from 'react-dom';
import { Header } from './Header';
import { Content } from './Content';

(() => {

  const resumeJson = JSON.parse(document.getElementById('resumeJson').value);

  const Component = () =>{
    return(
      resumeJson ? 
      <div>
        <div className="d-flex flex-row align-items-center p-2">
          <Header
            resumeJson={resumeJson}
          />
        </div>
        <div className="d-flex flex-row align-items-center p-2">
          <Content
            resumeJson={resumeJson}
          />
        </div>
      </div>
    : <></>
    );
  }

  ReactDOM.render(
    <Component/>,
    document.getElementById('target-component')
  );

})();

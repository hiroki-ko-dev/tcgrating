import React from 'react';
import ReactDOM from 'react-dom';

(() => {
    function Counter(props){
        return <div>0 {props.color}</div>
    }
    ReactDOM.render(
        <Counter color="red"/>,
        document.getElementById('example')
    );
})();

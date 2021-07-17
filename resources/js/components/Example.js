import React from 'react';
import ReactDOM from 'react-dom';

function Example() {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Example Component</div>

                        <div className="card-body">I'm an example component!</div>
                            ああああ
                    </div>
                </div>
            </div>
        </div>
    );
}

const element = <h1>Hello, react_test</h1>;

if (document.getElementById('example')) {
    ReactDOM.render(element, document.getElementById('example'));
}


function approvalCheck(){
    if( window.confirm('承認してよろしいですか？') ) {
        return true;
    }else{
        return false;
    }
}

function rejectCheck(){
    if( window.confirm('却下してよろしいですか？') ) {
        return true;
    }else{
        return false;
    }
}

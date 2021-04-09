
function approvalCheck(user_id){
    if( window.confirm('承認してよろしいですか？') ) {
        var user = document.createElement('input');
        user.type = 'hidden';
        user.name = 'user_id';
        user.value =  user_id;
        document.form.action="/team/user/"+user_id;
        document.form.appendChild(user);

        var status = document.createElement('input');
        status.type = 'hidden';
        status.name = 'status';
        status.value = '1';
        document.form.appendChild(status);
        document.form.submit();
    }else{
        return false;
    }
}

function rejectCheck(user_id){
    if( window.confirm('却下してよろしいですか？') ) {
        var user = document.createElement('input');
        user.setAttribute('type', 'hidden');
        user.setAttribute('name', 'user_id');
        user.setAttribute('value', user_id);
        document.form.action="/team/user/"+user_id;
        document.form.appendChild(user);

        var status = document.createElement('input');
        status.setAttribute('type', 'hidden');
        status.setAttribute('name', 'status');
        status.setAttribute('value', '2');
        document.form.appendChild(status);
        document.form.submit();
    }else{
        return false;
    }
}

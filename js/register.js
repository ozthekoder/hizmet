$(document).ready(function(){
    $('input[name="dob"]').inputmask({
        mask: '99/99/9999'
    });
    
    $('input[name="phone"]').inputmask({
        mask: '(999)999-9999'
    });
    
    $('input[name="zip"]').inputmask({
        mask: '99999'
    });
});

$(document).on('click', '.oz-select .dropdown-menu li', function(){
    var button = $(this).closest('.oz-select').find('button');
    button.attr('value', $(this).attr('value'));
    button.html($(this).find('a').text() + '<span class="caret" style="margin-left: 2px;"></span>');
});

$(document).on('change.bs.fileinput', function(e){
    if($(e.target).hasClass('fileinput'))
        $('#avatar').submit();
});

window.startCropper = function(modal){
    $('body').append(modal);
    $('#cropper').modal({
       backdrop: 'static',
       allowCancel: true
    });
};

window.stopCropper = function(data){
    $('#signup-avatar-w').val(50);
    $('#signup-avatar-h').val(50);
    $('#signup-avatar-x').val(10);
    $('#signup-avatar-y').val(10);
    $('#cropped').val("false");
    $('#preview-holder').attr('src', data.src + '?' + Date.now());
    $('#final-avatar').val(data.src);
    $('#cropper').modal('hide');
};

$(document).on('click', '#cropper-done', function(){
    $('#avatar-crop').data('Jcrop').destroy();
    $('#cropped').val("true");
    $('#avatar').submit();
});

$(document).on('hidden.bs.modal', function(){
    $('#signup-avatar-w').val(50);
    $('#signup-avatar-h').val(50);
    $('#signup-avatar-x').val(10);
    $('#signup-avatar-y').val(10);
    $('#cropped').val("false");
    $('#cropper').remove();
    $('[data-dismiss="fileinput"]').click();
//    $(document).off('shown.bs.modal');
});

$(document).on('shown.bs.modal', function(){
    var saveCoords = function(c){
        $('#signup-avatar-w').val(c.w);
        $('#signup-avatar-h').val(c.h);
        $('#signup-avatar-x').val(c.x);
        $('#signup-avatar-y').val(c.y);
    };
    
    $('#avatar-crop').Jcrop({
        onSelect: saveCoords,
        onChange: saveCoords,
        aspectRatio: 1,
        maxSize:[258, 258],
        setSelect: [10,10,60,60],
        bgColor: '#fff',
        keySupport: false
    });
});

$(document).on('click', '#submit-everything', function(){
    var params = {};
    
    if($('input[name="email"]').val() !== '')
    {
        var value = $('input[name="email"]').val();
        if(value === $('input[name="email-repeat"]').val())
        {
            if(validateEmail(value))
                params.email = value;
            else
            {
                alert('Invalid E-mail type!');
                return;
            }
        }
        else
        {
            alert('The two e-mail fields do not match!');
            return;
        }
    }
    else
    {
        alert('You have left the e-mail field empty!');
        return;
    }
    
    if($('input[name="password"]').val() !== '')
    {
        var value = $('input[name="password"]').val();
        if(value === $('input[name="password-repeat"]').val())
        {
            if(value.length >= 8)
                params.password = value;
            else
            {
                alert('Password should be at least 8 characters!');
                return;
            }
        }
        else
        {
            alert('The two password fields do not match!');
            return;
        }
    }
    else
    {
        alert('You have left the password field empty!');
        return;
    }
    
    if($('input[name="firstName"]').val() !== '')
    {
        var value = $('input[name="firstName"]').val();
        params.firstName = value;
       
    }
    else
    {
        alert('You have left the First Name field empty!');
        return;
    }
    
    if($('input[name="lastName"]').val() !== '')
    {
        var value = $('input[name="lastName"]').val();
        params.lastName = value;
       
    }
    else
    {
        alert('You have left the Last Name field empty!');
        return;
    }
    
    if($('input[name="dob"]').val() !== '')
    {
        var value = $('input[name="dob"]').val();
        var arr = value.split('/');
        var str = arr[2] + '-' + arr[0] + '-' + arr[1];
        params.dob = str;
       
    }
    else
    {
        alert('You have left the Date of Birth field empty!');
        return;
    }
    
    if($('button[name="gender"]').val() !== '')
    {
        var value = $('button[name="gender"]').val();
        params.gender = value;
       
    }
    else
    {
        alert('Please select a gender!');
        return;
    }
    
    if($('button[name="nationality"]').val() !== '')
    {
        var value = $('button[name="nationality"]').val();
        params.nationality = value;
       
    }
    else
    {
        alert('Please select a nationality!');
        return;
    }
    
    if($('input[name="finalAvatarName"]').val() !== '')
    {
        var value = $('input[name="finalAvatarName"]').val();
        params.avatar = value;
       
    }
    else
    {
        alert('Please upload an image for your avatar!');
        return;
    }
    
    if($('input[name="street"]').val() !== '')
    {
        var value = $('input[name="street"]').val();
        params.street = value;
       
    }
    else
    {
        alert('You have left the Street Address field empty!');
        return;
    }
    
    if($('input[name="city"]').val() !== '')
    {
        var value = $('input[name="city"]').val();
        params.city = value;
       
    }
    else
    {
        alert('You have left the City field empty!');
        return;
    }
    
    if($('button[name="state"]').val() !== '')
    {
        var value = $('button[name="state"]').val();
        params.state = value;
       
    }
    else
    {
        alert('Please select a state!');
        return;
    }
    
    if($('input[name="zip"]').val() !== '')
    {
        var value = $('input[name="zip"]').val();
        params.zip = value;
       
    }
    else
    {
        alert('You have left the Zip Code field empty!');
        return;
    }
    
    if($('input[name="phone"]').val() !== '')
    {
        var value = $('input[name="phone"]').val();
        params.phone = value;
       
    }
    else
    {
        alert('You have left the Phone field empty!');
        return;
    }
    
    $.post(url('ajax/signup'), params, function(data){
        alert(data.message);
        if(data.status)
        {
            window.location.href = url('apply');
        }
    }, 'json');
    
    console.log(params);
});


function validateEmail(email){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
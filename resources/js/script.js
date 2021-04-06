const form = document.getElementById('login-form');
form.onsubmit = function (e)
{
    e.preventDefault();
    const formData = new FormData(form);

    axios.post('/api/signin', formData)
        .then(function (response) {
            if (response.data.success === true)
            {
                window.location.replace(response.data.redirectTo);
            }
            console.log(response.data);
        });
}
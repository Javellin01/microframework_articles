axios({
    method: 'post',
    url: '/api/signin',
    data: {
        username: 'thislogin',
        password: 'thispassword',
    }
})
.then(function (response) {
    console.log(response.data);
});
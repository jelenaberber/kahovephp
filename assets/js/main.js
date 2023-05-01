window.onload = () => {

    if ($('#poll').length) {
        // Poll();
    }
    if ($('#products').length) {
        loadProducts();
        sortProducts();
        usersAdminPanel
    }
    if ($('#users').length) {
        usersAdminPanel
    }
    function ajaxCallBack(url, method, result, data={}) {
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "json",
            success: result,
            error: function (xhr) {
                // console.log(xhr);
            }
        })
    }

    //***********************************Registracija***********************************
    $('#register-button').click(function () {
        let firstName, lastName, email, password, confPassword;
        firstName = $('#firstName');
        lastName = $('#lastName');
        email = $('#email');
        password = $('#password');
        confPassword = $('#confirm-password');

        var errorCount = 0;
        var regexForName = /^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15})?$/;
        var regexForEmail = /^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i;
        var regexForPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
        errorCount += check(firstName, regexForName, "Ime nije u dobrom formatu.", '#firstNameMessage');
        errorCount += check(lastName, regexForName, "Prezime nije u dobrom formatu.", '#lastNameMessage');
        errorCount += check(email, regexForEmail, "Email nije u dobrom formatu.", '#emailMessage');
        errorCount += check(password, regexForPassword, "Lozinka mora imati bar jedno malo slovo, jedno veliko slovo i bar jedan broj.", '#passwordMessage');



        if (password.val() == '') {
            $('#confPasswordMessage').html('Lozinke se ne podudaraju.');
        } else if (password.val() != confPassword.val()) {
            $('#confPasswordMessage').html('Lozinke se ne podudaraju.');
        } else {
            errorCount++
        }
        errorCount = 5
        console.log(errorCount)
        if (errorCount == 5) {
            var data = {
                firstName: $('#firstName').val(),
                lastName: $('#lastName').val(),
                email: $('#email').val(),
                password: $('#password').val()
            }
        }
        ajaxCallBack('models/register.php', 'post', function (data) {
            window.location ='http://localhost/php1_sajt/index.php'
        }, data)

    })
    function check(variable, regex, message, labelId) {
        let value = variable.val();
        console.log(regex.test(value))
        if (value == '') {
            variable.addClass('error');
            return false;
        } else if (!regex.test(value)) {
            $(labelId).html(message);
            return false;
        } else {
            variable.removeClass('error');
            $(labelId).html('');
            return true;
        }
    }
    // ***********************************Logovanje***********************************
    $("#login-form").submit(function (event) {
        let email, password;
        email = $('#logEmail');
        password = $('#logPassword');
        var errorCount = 0;
        var regexForEmail = /^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i;
        var regexForPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
        errorCount += check(email, regexForEmail, "Invalid e-mail", '#emailMessage');
        errorCount += check(password, regexForPassword, "Invalid password.", '#passwordMessage');
        if (errorCount != 2) {
            event.preventDefault();
        }
    })

    // ***********************************Kontakt***********************************
    $("#contactForm").submit(function (event) {
        let email, name, text;
        email = $('#email');
        name = $('#name');
        text = $('#text');
        var errorCount = 0;
        var regexForEmail = /^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i;
        var regexFullName = /^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}){0,2}$/;
        errorCount += check(email, regexForEmail, "Invalid e-mail", '#emailMessage');
        errorCount += check(name, regexFullName, "Invalid name.", '#nameMessage');
        if(text.val() == ''){
            text.addClass('error');
        }
        else {
            text.removeClass('error');
            errorCount++
        }
        if (errorCount != 3) {
            event.preventDefault();
        }
    })

    // ***********************************Artworks***********************************
    $(document).on("click",".purchase",function(){
        let id = $(this).data('id');
        var data = {
            id_product: id
        }
        ajaxCallBack('models/addProductsToCart.php', 'get', function (data){
            window.location ='http://localhost/php1_sajt/index.php?page=register'
        }, data)
    });

    function loadProducts(data = {}){
        ajaxCallBack('models/getProducts.php', 'get', function (data){
            printProducts(data)
        }, data )
    }

    function printProducts (data){
        var html = "";
        for(let product of data.products){
            html += `<div class="col-3 mx-1 my-3">
                        <div class="card h-100 w-100">
                            <img src="assets/img/${product.picture_src}" class="card-img-top" alt="${product.name}">
                            <div class="card-body d-flex flex-column align-items-center">
                                <h5 class="card-title">${product.name}</h5>
                                <p>Price: ${product.price}.00$</p>
                                <button type="button" class="btn btn button purchase" data-id="${product.id}">Purchase Now</button>
                            </div>
                        </div>
                    </div>`
        }
        $("#products").html(html)
    }

    function sortProducts(){
        $("#search").on('keyup', function () {
            checkFilter()
        });
        $('#sort').change(function (){
            checkFilter()
        })
        $('#categories').change(function (){
            checkFilter();
        })
    }

    function checkFilter(){
        let search = $('#search').val();
        console.log(search)
        let sort = $('#sort').val();
        let filter = $('#categories').val();
        filterChange(sort, search, filter)
    }
    function filterChange(val, search, filter){
        var data = {
            "sortBy" : val,
            "search" : search,
            "filter" : filter
        }
        loadProducts(data);
    }

    // ***********************************Korpa***********************************
    $(document).on("click",".plus",function(){
        let element = $(this);
        let id = element.data('plus');
        var amount = $('.amount-' + id).data('amount');
        amount+=1;
        var data = {
            id_product_in_cart: id,
            amount: amount
        }
        ajaxCallBack('models/increaseAmount.php', 'get', data, function (result){
            if (result.result) {
                $('.amount-' + result.id_product).html(result.amount);
                $('.amount-' + id).data('amount', result.amount);
            }
            else {
                alert('neuspesno menjanje kolicine pokusajte ponovo');
            }
        })
    });
    $(document).on("click",".minus",function(){
        let element = $(this);
        let id = element.data('minus');
        var amount = $('.amount-' + id).data('amount');
        amount-=1;
        $('p[data-p=' + id + ']').html(amount)
        if(amount !== 0){
            var data = {
                id_product_in_cart: id,
                amount: amount
            }
            ajaxCallBack('models/reduceAmount.php', 'get', data, function (result){
                if (result.result) {
                    $('.amount-' + result.id_product).html(result.amount);
                    $('.amount-' + id).data('amount', result.amount);
                }
                else {
                    alert('neuspesno menjanje kolicine pokusajte ponovo');
                }
            })
        }

    });
    $(document).on("click",".deleteItem",function(){
        let id = $(this).data('delete');
        console.log(id)
        var data = {
            id_product_in_cart: id
        }
        ajaxCallBack('models/deleteItem.php', 'get', data, function (result){
            $('.product-' + result.id).remove();
            })
    });

    $("#order").submit(function (event) {
        let email, name, address;
        email = $('#email');
        name = $('#name');
        address = $('#address')
        var errorCount = 0;
        var regexForName = /^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15})?$/;
        var regexForEmail = /^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i;
        let regexForAddress = /^(([A-ZŠĐČĆŽ][a-zščćđž\d]+)|([0-9][1-9]*\.?))(\s[A-Za-zŠĐŽĆČščćđž\d]+){0,7}\s(([1-9][0-9]{0,5}[\/-]?[A-Z])|([1-9][0-9]{0,5})|(BB))\.?$/;
        errorCount += check(email, regexForEmail, "Invalid e-mail", '#spanEmail');
        errorCount += check(name, regexForName, "Invalid name.", '#spanName');
        errorCount += check(address, regexForAddress, "Invalid address.", '#spanAddress');
        if (errorCount != 3) {
            event.preventDefault();
        }
        //todo modal sa uspesnom porukom
    })

    //***********************************Anketa***********************************
    function Poll() {
        document.querySelector("#buttonPoll").onclick = function(e){
            console.log(123)
            let qualityRadios = false
            let interestArray = []
            $("#checkBoxDiv input:checked").get().map(x => interestArray.push(x.value))
            qualityRadios = $("input:radio[name='optionsRadios']:checked").val()

            let data = {
                "interest": interestArray,
                "quality": qualityRadios
            };

            if (qualityRadios && interestArray.length){
                $(".errorPoll").html('');
                ajaxCallBack("models/setPoll.php", "get", data, function () {
                    $("#poll").html('');
                    $(".errorPoll").html('<img src="assets/img/poll.png" alt="Thank you" class="col-3"/><p class="alert alert-success">Your response has been recorded. Thank you for your time! Return to home page <a href="index.php?page=home" class="td-u"> here.</a></p>');
                })
            }
            else{
                $(".errorPoll").html('<p class="alert alert-danger">All fields ar required</p>');
                e.preventDefault();
            }
        }
    }

    //***********************************Admin panel***********************************
    usersAdminPanel()
    function usersAdminPanel(data = {}){
        ajaxCallBack('models/adminPanel/getUsers.php', 'get', function (data){
            printUsers(data)
        }, data )
    }
    function printUsers(data){
        let html = '<div class="col-12 d-flex flex-column align-items-center">\n' +
            '        <h2 class="text-center fs-3 mt-5">Users'+'('+ data.users.length+')' +'</h2>\n        <table class="col-12 text-center mt-3">\n            <thead>\n                <tr>\n                    <th scope="col"></th>\n                    <th scope="col">Name</th>\n                    <th scope="col">Email</th>\n                    <th scope="col">Manage</th>\n                </tr>\n            </thead>\n            <tbody>';
        let rb = 1;
        for(let el of data.users){
            html += `
                <tr class="table-success">
                    <th scope="row"><?=$i++?></th>
                    <td>${el.first_name} ${el.last_name}</td>
                    <td>${el.email}</td>`
            if(el.active == 2){
                html += `<td class="text-dark">Admin</td>
                        </tr>
                    </tbody>
                </table>`;
            }
            else{
                if(el.active == 0){
                    html += `<td><button id="activeUser" data-id="${el.id}" data-status="${el.active}" class="btn btn-success">Activate</button></td>`
                }
                else{
                    html += `<td><button id="activeUser" data-id="${el.id}" data-status="${el.active}" class="btn btn-danger">Deactivate</button></td>`
                }

            }
        }
        html +=`</tr>
                    </tbody>
                </table>`
        $("#users").html(html);

    }
    $(document).on("click","#activeUser",function (){
        let id = $(this).data('id');
        let status = $(this).data('status');
        let data = {
            'id' : id,
            'status' : status
        }
        ajaxCallBack('models/adminPanel/statusUser.php', 'get', function(data){
            usersAdminPanel();
        }, data)
    });
}
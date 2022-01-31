const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

const UserUpdateView = (id) =>{

    $.ajax({
        type: "POST",
        url: "/user/view",
        data: {
            _token: CSRF_TOKEN, id: id,
        },
        success: function (data) {
                if(data){
                    console.log(data);
                    document.getElementById("edit_id").value = id;
                    document.getElementById("edit_name").value = data.name;
                    document.getElementById("edit_email").value = data.email;
                    document.getElementById("edit_position").value = data.position;
                    document.getElementById("edit_roles").value = data.roles;
                    document.getElementById("edit_status").value = data.status;
                    $('#edit').modal('show');
                }
        },
        error: function () {
            alert('Error... 5011');
        }
    })
};

const CategoryUpdateView = (id) =>{

    $.ajax({
        type: "POST",
        url: "/products/category-view",
        data: {
            _token: CSRF_TOKEN, id: id,
        },
        success: function (data) {
            if(data){
                console.log(data);
                document.getElementById("edit_id").value = id;
                document.getElementById("edit_name").value = data.name;
                document.getElementById("edit_main").value = data.main_category;
                if (data.main_category == "0") {
                    document.getElementById("edit_main").setAttribute("disabled", "disabled");
                } else {
                    document.getElementById("edit_main").removeAttribute("disabled");
                }
                document.getElementById("edit_status").value = data.status;
                $('#categoryView').modal('show');
            }
        },
        error: function () {
            alert('Error... 5011');
        }
    })
};

const ProductUpdateView = (id, url) =>{

    $.ajax({
        type: "POST",
        url: "/products/product-view",
        data: {
            _token: CSRF_TOKEN, id: id,
        },
        success: function (data) {
            if(data){
                console.log(data.description);
                document.getElementById("edit_id").value = id;
                document.getElementById("edit_name").value = data.name;
                document.getElementById("edit_author").value = data.author;
                document.getElementById("edit_category").value = data.category_id;
                document.getElementsByClassName("note-editable")[0].innerHTML = data.description;
                document.getElementById("current_img").innerHTML = `<img style="height: 150px; width: auto;" src="${url + data.img}" />`;
                document.getElementById("edit_price").value = data.price;
                document.getElementById("edit_status").value = data.status;
                $('#productView').modal('show');
            }
        },
        error: function () {
            alert('Error... 5011');
        }
    })
};

const makePassword = () =>{
        document.getElementById("edit_password").value = generatePassword(8);
};

const makePassword_add = () =>{
    document.getElementById("add_password").value = generatePassword(8);
};





const generatePassword = (length) => {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%!';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
};


const SliderDelete = (id)=>{

    let check = confirm("Silinən slider geri qaytarılmır!");

    if(check){
        location.href = `/settings/sliders/delete/${id}`;
    }else{
        alert("İmtina edildi");
    }

};

const ProductDelete = (id) =>{

    let check = confirm("Silinən məhsul geri qaytarılmır!");

    if(check){
        location.href = `/products/product-delete/${id}`;
    }else{
        alert("İmtina edildi");
    }

};


const ViewCustomer = (id,url) =>{

    $.ajax({
        type: "POST",
        url: "/customer/view",
        data: {
            _token: CSRF_TOKEN, id: id,
        },
        success: function (data) {
                console.log(data);

                if(data.status){
                    document.getElementById("img").innerHTML = `<img style="height: 150px; width: auto;" src="${url + data.user.img}" />`;
                    document.getElementById("name").innerHTML = data.user.name;
                    document.getElementById("email").innerHTML = data.user.email;
                    document.getElementById("phone").innerHTML = data.customer.phone;
                    document.getElementById("address").innerHTML = data.customer.address;
                    document.getElementById("date").innerHTML = data.customer.birthday;
                    document.getElementById("status").innerHTML = data.customer.status === "1" ? "VIP"  :
                        data.customer.status === "2" ? "Standart" : "İstənməyən müştəri";
                    $('#customerView').modal('show');
                }
                else{
                    alert("Informasiya Yoxdur");
                }



        },
        error: function () {
            alert('Error... 5011');
        }
    })
};

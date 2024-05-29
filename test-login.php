<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าเข้าสู่ระบบ</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
	body {
    font-family: sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.container {
    width: 400px;
    margin: 50px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

a {
    color: #4CAF50;
    text-decoration: none;
}

.img-center {
	display: flex;
    justify-content: center;
    align-items: center;
}

</style>
<body>
    <div class="container">
		<div class="row img-center">
			<img src="images/logo_small.png" width="200" class="logo">		
		</div>
        <h1>เข้าสู่ระบบ</h1>
        <form action="login.php" method="post">
            <label for="username">ชื่อผู้ใช้:</label>
            <input type="text" id="username" name="username" required style="padding: 10px 0px;">

            <label for="password">รหัสผ่าน:</label>
            <input type="password" id="password" name="password" required style="padding: 10px 0px;">

            <button type="submit">เข้าสู่ระบบ</button>
        </form>

        <p>ไม่มีบัญชี? <a href="signup.html">สมัครสมาชิก</a></p>
    </div>
	<div class="container">
		<div class="row img-center">
			<img src="images/logo_small.png" width="200" class="logo">
		</div>
		<h1 align="center" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">Smart Broker System</h1>
		<form class="form-horizontal" method="post" onSubmit="return validateForm();" >
            <div class="col-md-12 ">                              
                <div class="form-group row col-md-12 ">
                    <label for="code_company" class="col-md-3 control-label text-left">CompanyCode</label>
                    <div class="col-md-9" style="display: flex; justify-content: center; align-items: center;">
                        <input type="text" id="code_company" name="code_company" class="form-control" placeholder="CompanyCode"  required >
                    </div>
                </div>
                <div class="form-group row col-md-12 ">
                    <label for="inputEmail3" class="col-md-3 control-label text-left">Username</label>
                    <div class="col-md-9" style="display: flex; justify-content: center; align-items: center;">
                        <input type="text" id="username" name="username" class="form-control" id="inputEmail3" placeholder="Username"  required>
                    </div>
                </div>
                <div class="form-group row col-md-12 ">
                     <label for="inputPassword3" class="col-md-3 control-label text-left">Password</label>
                    <div class="col-md-9" style="display: flex; justify-content: center; align-items: center;">
                        <input type="password" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group row col-md-12 ">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9" style="display: flex; justify-content: center; align-items: center;">
                        <input type="text" id="company" name="company" class="form-control" readOnly>
                    </div>
                </div>
            </div>
			<div class="form-horizontal" >
				<div class="panel-body p-20" >
					<div class="form-group mt-20 " style="display: flex; align-items: center; justify-content: space-between;">
						<div class="col-sm-6 text-left"  >
							<a href="forgot_password.php" style="color: #4590B8;">
								 Forget Password
							</a>
						</div> 
						<div class="col-sm-6 text-right"  >
							<button style="background-color: #0275d8;color: #F9FAFA; padding: 3px 16px 3px 16px;" type="submit" name="login" class="btn  btn-labeled">login
							</button>
						</div>
					</div> 
				</div>
			</div>
        </form>
	</div>
	<script>
    function validateForm() {
        var company_value = document.getElementById("company").value;
        if (company_value!="") {
            // document.getElementById("loading-overlay").style.display = "flex";
            return true;
        }else{
            // alert("Please enter the correct company code.");
            showAlert("Your company code incorrect.");
            return false;
        }
    }
</script>

        <script>
            var company_object = document.getElementById("code_company");
            company_object.addEventListener("change", function() {
                document.getElementById("company").value = '';
                $.get('get_company_name.php?code_company=' + $(this).val().toUpperCase(), function(data){
                    var result = JSON.parse(data);
                    $.each(result, function(index, item){
                        document.getElementById("company").value = item.company_name;
                    });
                });
            });
        </script> 
	
</body>
</html>




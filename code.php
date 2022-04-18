
<?php
//center/admin/images.js.css.كل الصفحات
// connecting in database
$conn = mysqli_connect("localhost", "root", "", "center_db");
if (!$conn) {
  die("No connect" . mysqli_connect_errno());
}

// insert  data with image|file
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $detail = $_POST['detail'];
  if (file_exists($_FILES['image']['tmp_name'])) {
    $old_img_name = $_FILES['image']['name'];
    $expload_name = explode(".", $old_img_name);
    $ext = end($expload_name);
    $imageName = "img" . time() . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/dep/' . $imageName);
    $sql = "insert into department (name,detail,image) values ('$name','$detail','$imageName')";
    include "conn.php";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $msg = '<div class="alert alert-success" role="alert">
                تمت عملية الاضافة بنجاح
              </div>';
    } else {
      $msg = '<div class="alert alert-danger" role="alert">
                لم تتم عملية الاضافة بنجاح
              </div>';
    }

    mysqli_close($conn);
  }
}

// insert data without image|file
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $detail = $_POST['detail'];
  $sql = "insert into department (name,detail) values ('$name','$detail')";
  include "conn.php";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $msg = '<div class="alert alert-success" role="alert">
      تمت عملية الاضافة بنجاح
    </div>';
  } else {
    $msg = '<div class="alert alert-danger" role="alert">
      لم تتم عملية الاضافة بنجاح
    </div>';
  }

  mysqli_close($conn);
}

// show data using table with while 
include "conn.php";
$sql = "select * from department";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $key = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    echo '
        <tr class="align-middle">
          <th scope="row">' . ++$key . '</th>
          <td>' . $row['name'] . '</td>
          <td><img width="100px" src="../images/dep/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
          <td><a href="depedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
          <td><a href="depdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
        </tr>
        
        ';
  }
} else {
  echo '<tr class="align-middle">
     <td colspan="5" scope="row">لا يوجد بيانات يمكن عرضها...</td>
 </tr>';
}

// show data with foreach
include "conn.php";
$sql = "select * from department";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  foreach ($result as $key => $row) {
    echo '
    <tr class="align-middle">
      <th scope="row">' . ++$key . '</th>
      <td>' . $row['name'] . '</td>
      <td><img width="100px" src="../images/dep/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
      <td><a href="depedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
      <td><a href="depdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
    </tr>
    
    ';
  }
} else {
  echo '<tr class="align-middle">
     <td colspan="5" scope="row">لا يوجد بيانات يمكن عرضها...</td>
 </tr>';
}
//show data from two table
include "conn.php";
	$sql = "select students.id,students.name,students.email,students.age,
	students.address,students.phone,department.id as dId,department.name as dName
	from students join department on students.depnum=department.id ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$key = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			echo '
				<tr class="align-middle">
					<th scope="row">' . ++$key . '</th>
					<td>' . $row['name'] . '</td>
					<td>' . $row['email'] . '</td>
					<td>' . $row['age'] . '</td>
					<td>' . $row['address'] . '</td>
					<td>' . $row['phone'] . '</td>
					<td>' . $row['dName'] . '</td>
					<td><a href="studentedit.php?id='.$row['id'].'" class="btn btn-danger">edit</a></td>
					<td><a href="studentdelete.php?id='.$row['id'].'" class="btn btn-danger">delete</a></td>
				</tr>
			';
		}
	} else {
		echo '<tr class="align-middle">
		 <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
	 </tr>';
	}
//search from data in database
		include "conn.php";
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$sql = "select students.id,students.name,students.email,students.age,
		students.address,students.phone,department.id as dId,department.name as dName
		from students join department on students.depnum=department.id
		where students.name like '%$name%' ";
		} else {
			$sql = "select students.id,students.name,students.email,students.age,
		students.address,students.phone,department.id as dId,department.name as dName
		from students join department on students.depnum=department.id ";
		}

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$key = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				echo '
					<tr class="align-middle">
						<th scope="row">' . ++$key . '</th>
						<td>' . $row['name'] . '</td>
						<td>' . $row['email'] . '</td>
						<td>' . $row['age'] . '</td>
						<td>' . $row['address'] . '</td>
						<td>' . $row['phone'] . '</td>
						<td>' . $row['dName'] . '</td>
						<td><a href="studentedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
						<td><a href="studentdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
					</tr>
				';
			}
		} else {
			echo '<tr class="align-middle">
			 <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
		 </tr>';
		}
//show data in select 
 <select class="form-select" name="dName" aria-label="Default select example">
	<?php
	include "conn.php";
	$sql = "select id,name from department";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($drow = mysqli_fetch_assoc($result)) {
	?>
			<option 
			<?php if ($drow['id'] == $row['depnum']) { ?> 
				selected="selected" 
				<?php } ?> 
				value='<?php echo $drow['id']; ?>'>
				<?php echo $drow['name'];  ?>
			</option>

	<?php }
	} ?>
</select>
//edit data with image|file
if (isset($_GET['id'])) {
  include "conn.php";
  $sqlGetDepData = "select * from department where id=" . $_GET['id'];
  $result = mysqli_query($conn, $sqlGetDepData);
  $row = mysqli_fetch_assoc($result);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    if (file_exists($_FILES['image']['tmp_name'])) {
      $old_img_path = "../images/" . $row['image'];
      unlink($old_img_path);
      $new_img_name = $_FILES['image']['name'];
      $expload_name = explode(".", $new_img_name);
      $ext = end($expload_name);
      $imageName = "img" . time() . "." . $ext;
      move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $imageName);
      $sql = "update department set name='$name',detail='$detail',image='$imageName' where id=" . $_GET['id'];
      $res = mysqli_query($conn, $sql);
      header('location:depshow.php?success=true');
      exit();
    } else {

      $sql = "update department set name='$name',detail='$detail' where id=" . $_GET['id'];
      $res = mysqli_query($conn, $sql);
      header('location:depshow.php?success=true');
      exit();
    }
  }
}

// edit data without image
if (isset($_GET['id'])) {
  include "conn.php";
  $sqlGetDepData = "select * from department where id=" . $_GET['id'];
  $result = mysqli_query($conn, $sqlGetDepData);
  $row = mysqli_fetch_assoc($result);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $sql = "update department set name='$name',detail='$detail',image='$imageName' where id=" . $_GET['id'];
    $res = mysqli_query($conn, $sql);
    header('location:depshow.php?success=true');
    exit();
  }
}

// delete data with image|file
if (isset($_GET['id'])) {
  include 'conn.php';
  $querySelect = 'select * from department where id=' . $_GET['id'];
  $ResultSelectStmt = mysqli_query($conn, $querySelect);
  $fetchRecords = mysqli_fetch_assoc($ResultSelectStmt);
  $createDeletePath  = '../images/' . $fetchRecords['image'];
  if (unlink($createDeletePath)) {
    $sql = "delete from department where id=" . $_GET["id"];
    $rsDelete = mysqli_query($conn, $sql);
    if ($rsDelete) {
      header('location:depshow.php?success=true');
      exit();
    }
  }
}
// delete data without image|file
if (isset($_GET['id'])) {
  include 'conn.php';
  $sql = "delete from department where id=" . $_GET["id"];
  $rsDelete = mysqli_query($conn, $sql);
  if ($rsDelete) {
    header('location:depshow.php?success=true');
    exit();
  }
}
// logout code
session_start();
if (isset($_SESSION['id'])) {
  session_destroy();
  header('location:login.php');
}

// login code 
$msg = "";
if (isset($_POST['submit'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['password'];
  if (empty($username)) {
    $msg = "<div class='alert alert-danger' role='alert'>
      الرجاء ادخال اسم المستخدم
     </div>";
  } elseif (empty($_POST['password'])) {
    $msg = "<div class='alert alert-danger' role='alert'>
    الرجاء ادخال كلمة المرور
   </div>";
  } else {
    include "conn.php";
    $sql = "select * from users where username='$username' and password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      $msg = "<div class='alert alert-danger' role='alert'>
        خطأ في اسم المستخدم و كلمة المرور
       </div>";
    } else {
      $user = mysqli_fetch_assoc($result);
      $_SESSION['id'] = $user['id'];
      header('Location:home.php');
    }
  }
}

// check user is login!
//put this code in all page 
session_start(); 
if (!isset($_SESSION['id'])) {

  header('Location:login.php');
}
//موقع test1
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="css\bootstrap.rtl.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
<script src="js\bootstrap.min.js"></script>

<body>
<?php  include "conn.php";?>
    <?php
    // connecting in database
    
    if (isset($_POST['submit'])) {
        $head = $_POST['head'];
        $detail = $_POST['detail'];
        $sql = "insert into menu (head,detail) values ('$head','$detail')";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div class="alert alert-success" role="alert">
        تمت عملية الاضافة بنجاح
      </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
        لم تتم عملية الاضافة بنجاح
      </div>';
        }

        mysqli_close($conn);
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">اضافة مستخدم جديد</div>
                        <div class="card-body ">
                            <div class="row">

                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="head" class="col-sm-2 col-form-label">اسم المستخدم</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="head" class="form-control" id="head">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="detail" class="col-sm-2 col-form-label">كلمة المرور</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="detail" class="form-control" id="detail">
                                            </div>
                                        </div>

                                </div>
                                <div class="d-flex justify-content-end">
                                    <button name="submit" type="submit" class="btn btn-primary text-center">اضافة مستخدم</button>
                                </div>

    </form>











    <?php
    include "header.php";
    ?>
    <div class="container">
        <div class="row br-light" style="margin-top:80px">
            <article class="col-lg-12" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                <div class="card">
                    <div class="card-header text-center">الاقسام</div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table text-center">
                                    <thead>
                                        <tr style="vertical-align: middle;">
                                            <th scope="col">#</th>
                                            <th scope="col">اسم القسم</th>
                                            <th scope="col">صورة القسم</th>
                                            <th scope="col">حذف</th>
                                            <th scope="col">تعديل</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr style="vertical-align: middle;">
                                            <th scope="row">1</th>
                                            <td>تطبيقات الويب</td>
                                            <td><img width="100px" src="../admin/images/img1.png" alt=""></td>
                                            <td><a href="#" class=" btn btn-danger">edit</a></td>
                                            <td><a href="#" class=" btn btn-danger">delete</a></td>

                                        </tr>
                                        <tr style="vertical-align: middle;">
                                            <th scope="row">1</th>
                                            <td>تطبيقات الموبيال</td>
                                            <td><img width="100px" src="../admin/images/img1.png" alt=""></td>
                                            <td><a href="#" class=" btn btn-danger">edit</a></td>
                                            <td><a href="#" class=" btn btn-danger">delete</a></td>

                                        </tr> -->

                                        <?php include 'conn.php';
                                        $sql = "select * from menu";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $key = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr style="vertical-align: middle;">
                                                <th scope="row">' . $key . '</th>
                                                <td>' . $row['head'] . '</td>
                                                <td>' . $row['detail'] . '</td>

                                                <td>' . ' <a  href="menudelete.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg></a>' . '</td>
                                                <td>' . ' <a  href="edit.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                </a>' . '</td>
                                                
                                                </tr>
    
                                            </tr>';
                                                $key++;
                                            }
                                        } else {
                                            echo '<td colspan="5"><div style=" text-align: center;" class="alert alert-info" role="alert">
                                          لايوجد بيانات لعرضها 
                                        </div></td>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>

                    </div>

                </div>
            </article>

        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>





































//بداية كودي

//الربط هيكون من جدول الستيودنت مع دب نمبر
// عمر صفحة سلايدر
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.rtl.css">
    <title>H</title>
</head>

<body>
    <section>
        <div class="row">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
     

                    <?php
                    include "admin/conn.php";
                    $sql = "select * from news ";
                    $result = mysqli_query($conn, $sql);
                    $x = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $x ?>" class="<?php if ($x == 0) {
                                                                                                                                            echo 'active';
                                                                                                                                        } ?>" aria-current="true" aria-label="Slide $x"></button>
                    <?php
                            $x++;
                        }
                    } ?>
                </div>
                <div class="carousel-inner">
                    <?php
                    include "admin/conn.php";
                    $sql = "select * from news ";
                    $result = mysqli_query($conn, $sql);
                    $x = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <div class="carousel-item  <?php if ($x == 0) {
                                                            echo 'active';
                                                        } ?>">
                                <img src="images/<?php echo $row["image"]; ?>" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?php echo $row["title"]; ?></h5>

                                </div>
                            </div>
                    <?php
                            $x++;
                        }
                    } ?>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>
//admininsert
<?php
// session_start();
// if (!isset($_SESSION['id'])) {
//     header('location:login.php');
// }
// //لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php
    //insert dep data
    if (isset($_POST['submit'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        if (isset($_POST['isAdmin'])) {
            $type = 1;
        } else {
            $type = 0;
        }




        $sql = "insert into users(username,password,isAdmin) values('$username','$password','$type')";
        include 'conn.php';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم الاضافة بنجاح
      </div>';
        } else {
            echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم الاضافة بنجاح
       </div>';
        }
    }


    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">اضافة مستخدم جديد</div>
                        <div class="card-body ">
                            <div class="row">

                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">اسم المستخدم</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="username" class="form-control" id="username">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password" class="col-sm-2 col-form-label">كلمة المرور</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" class="form-control" id="password">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="isAdmin" class="col-sm-2 col-form-label">هل المستخدم مدير؟</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="isAdmin" class="form-chexk-input" id="isAdmin">
                                            </div>
                                        </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button name="submit" type="submit" class="btn btn-primary text-center">اضافة مستخدم</button>
                                </div>

    </form>
    </div>

    </div>

    </div>

    </div>
    </article>

    </div>
    </div>
    </form>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//adminshow
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>


    <div class="container">

        <?php

        ?>
        <div class="row br-light" style="margin-top:80px">
            <?php include 'sidebar.php' ?>
            <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                <div class="card">
                    <div class="col-md-3 text-end">

                    </div>
                    <div class="col-md-3 text-end">

                    </div>



                    <div class="card-body ">
                        <form action="" method="post">
                          
                        </form>
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table text-center">
                                    <thead>
                                        <tr style="vertical-align: middle;">
                                            <th scope="col">#</th>
                                            <th scope="col">اسم المستخدم</th>
                                            <th scope="col">كلمة المرور</th>
                                            <th scope="col">الصلاحية</th>
                                            <th scope="col">حذف</th>
                                            <th scope="col">تعديل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    include "conn.php";
                                    $sql = "select * from users";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        $key = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr class="align-middle">
                                                <th scope="row"> <?php echo ++$key ?> </th>
                                                <td> <?php echo $row['username'] ?> </td>
                                                <td> <?php echo $row['password'] ?> </td>
                                                <td> <?php echo $row['isAdmin']==1? "مدير":"مستخدم"?></td>

                                                   
                                                <td> <a   href="deleteusers.php?id=<?php echo $row["id"];?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg></a></td>
                                                <td> <a  href="editusers.php?id=<?php echo $row["id"]; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                </a></td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr class="align-middle">
                                        <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
                                    </tr>';
                                    }
                                    ?>
                                </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </article>

        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>
//conn
<?php
$conn=mysqli_connect('localhost','root','','center_db');

if(!$conn){
    die("no connect".mysqli_connect_error());
}
?>
//cp.php
<?php
session_start();
  if(!isset( $_SESSION['id'])){
      header('location:login.php');
  }
    //لازم يكون في اعلى الصفحة دائما

    ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
   

</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <div class="container">
    <div class="row br-light" style="margin-top:80px">
    <?php include'sidebar.php'?>

    <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
    <div class="card">
        <div class="card-header text-center">مرحبا بك يا <?php     echo $_SESSION['user'];?>في لوحة التحكم</div>

    </div>
    </article>
    </div>
    </div>
    
    <?php
    include "footer.php";
    ?>
  </body>
  
  </html>
  //deletdep
  <?php
include ('conn.php');

// start delte images

$sqldata = "select * From department where id=" .$_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
       
       if($row['image']!='defult.png'){
                $path='images/'.$row['image'];
                unlink($path);
        }
       
// end delte images

$sql="delete From department where id=".$_GET["id"];
$res=mysqli_query($conn,$sql);
header("location:depshow.php");

?>
//deletenews
<?php
include ('conn.php');

// start delte images

$sqldata = "select * From news where id=" .$_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
       
       if($row['image']!='defult.png'){
                $path='images/'.$row['image'];
                unlink($path);
        }
       
// end delte images

$sql="delete From news where id=".$_GET["id"];
$res=mysqli_query($conn,$sql);
header("location:newsshow.php");

?>
//deletestudents
<?php
include ('conn.php');

// start delte images

$sqldata = "select * From students where id=" .$_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
       
       if($row['image']!='defult.png'){
                $path='images/'.$row['image'];
                unlink($path);
        }
       
// end delte images

$sql="delete From students where id=".$_GET["id"];
$res=mysqli_query($conn,$sql);
header("location:studentshow.php");

?>
//deleteusers
<?php
include ('conn.php');



$sql="delete From users where id=".$_GET["id"];
$res=mysqli_query($conn,$sql);
header("location:adminshow.php");

?>
//dep.php
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
   

</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <div class=" row container" style="min-height: 320px; margin-right:110px;">
   <div class="card col-md-8">
       <div class="card-header text-right">اهلا بكم في القسم التقني</div>
       <div class="card-body text-right" style="height: 200px;">
    بيانات........تفاصيل القسم
    </div>
   </div> 
   <div class="card col-md-4">
       <div class="card-header text-center">التسجيل في القسم</div>
       <div class="card-body text-center">
           <a href="addstudent.php"><button class=" btn btn-info">تسجيل طالب جديد</button></a>
       </div>
   </div>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//depinsert
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php
    //insert dep data
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $detail = $_POST['detail'];
        
        if (file_exists($_FILES['image']['tmp_name'])) {

            $expolad_name = explode(".", $_FILES['image']['name']);
            $ext = end($expolad_name); //get extinsion
            $imageName = "img" . time() . "." . $ext; //new image name
            move_uploaded_file($_FILES['image']['tmp_name'], '../admin/images/' . $imageName); //move image to bath

            $sql = "insert into department(name,detail,image) values('$name','$detail','$imageName')";
            include 'conn.php';
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم الاضافة بنجاح
      </div>';
            } else {
                echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم الاضافة بنجاح
       </div>';
            }
        }
    }


    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">اضافة قسم جديد</div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="name" class="col-sm-2 col-form-label">عنوان القسم</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="detail" class="col-sm-2 col-form-label">التفاصيل</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="detail" id="detail" style="height: 150px"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label"> صورة القسم</label>
                                                <input class="form-control" name="image" type="file" id="image">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button name="submit" type="submit" class="btn btn-primary text-end">اضافة قسم</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </article>

            </div>
        </div>
    </form>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//depshow
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <div class="container">
        <div class="row br-light" style="margin-top:80px">
            <?php include 'sidebar.php' ?>
            <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                <div class="card">
                    <div class="card-header text-center">الاقسام</div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table text-center">
                                    <thead>
                                        <tr style="vertical-align: middle;">
                                            <th scope="col">#</th>
                                            <th scope="col">اسم القسم</th>
                                            <th scope="col">صورة القسم</th>
                                            <th scope="col">حذف</th>
                                            <th scope="col">تعديل</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr style="vertical-align: middle;">
                                            <th scope="row">1</th>
                                            <td>تطبيقات الويب</td>
                                            <td><img width="100px" src="../admin/images/img1.png" alt=""></td>
                                            <td><a href="#" class=" btn btn-danger">edit</a></td>
                                            <td><a href="#" class=" btn btn-danger">delete</a></td>

                                        </tr>
                                        <tr style="vertical-align: middle;">
                                            <th scope="row">1</th>
                                            <td>تطبيقات الموبيال</td>
                                            <td><img width="100px" src="../admin/images/img1.png" alt=""></td>
                                            <td><a href="#" class=" btn btn-danger">edit</a></td>
                                            <td><a href="#" class=" btn btn-danger">delete</a></td>

                                        </tr> -->

                                        <?php include 'conn.php';
                                        $sql = "select * from department";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $key = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr style="vertical-align: middle;">
                                                <th scope="row">' . $key . '</th>
                                                <td> <a class = "text-decoration-none" href ="details.php?id=' . $row["id"] . '" >' . $row['name'] . '</a> </td>
                                                <td><img width="100px" src="../admin/images/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
                                                <td>' . ' <a  href="delete.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg></a>' . '</td>
                                                <td>' . ' <a  href="edit.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                </a>' . '</td>
                                                
                                                </tr>
    
                                            </tr>';
                                                $key++;
                                            }
                                        } else {
                                            echo '<td colspan="5"><div style=" text-align: center;" class="alert alert-info" role="alert">
                                          لايوجد بيانات لعرضها 
                                        </div></td>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 text-center">
                                <a href="depinsert.php"><button type="button" class="btn btn-info">اضافة قسم</button></a>

                            </div>
                        </div>

                    </div>

                </div>
            </article>

        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>
//depdetaile
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التفاصبل
    </title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
</head>
<?php
if (isset($_GET['id'])) {
  include "conn.php";
  $deptDelet = "SELECT * FROM department where id =" . $_GET['id'];
  $res  = mysqli_query($conn, $deptDelet);
  $row = mysqli_fetch_assoc($res);
}
?>
<body>
    <section>
        <div class="container">
            <div class="row">
                <h1 class="text-center bg-successs py-1 bg-success text-light">hello</h1>
            </div>
            
            <div class="row text-center">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center"><?php if (isset($row['name'])) echo $row['name']; ?></h4>
                    </div>
                    <div class="card-body">
                    <?php if (isset($row['image'])) echo '<img src="../admin/images/' . $row['image'] . '" alt="' . $row['image'] . '" height="300px">'; ?>                        <div class="row"> 
                            <h1><?php if (isset($row['detail'])) echo $row['detail']; ?></h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="js\bootstrap.min.js"></script>

</body>

</html>
//depedit
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php
    //اظهار البيانات القديمة
    if (isset($_GET['id'])) {
        include 'conn.php';
        $sqldata = "select * from department where id=" . $_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
    }
//نهاية اظهار البيانانت
//تحديث البيانات 
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $detail = $_POST['detail'];
        $imageName='';

        if (file_exists($_FILES['image']['tmp_name'])) {
            $old_img_path="../admin/images/".$row['image'];
            unlink($old_img_path);
            $old_img_name=$_FILES['image']['name'];
            $expolad_name = explode(".", $_FILES['image']['name']);
            $ext = end($expolad_name); //get extinsion
            $imageName = "img" . time() . "." . $ext; //new image name
            move_uploaded_file($_FILES['image']['tmp_name'], '../admin/images/' . $imageName); //move image to bath

            $sql = "UPDATE `department` SET `name` = '$name',
            `detail` = '$detail',image='$imageName' WHERE `department`.`id` =" . $_GET['id'];
            $result = mysqli_query($conn, $sql);
            if ( $result ) {
                echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم التحديث بنجاح
      </div>';
            } else {
                echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم التحديث بنجاح
       </div>';
            }
        }else{
            $sqla="UPDATE `department` SET `name` = '$name',
            `detail` = '$detail' WHERE `department`.`id` =" . $_GET['id'];
                        $res = mysqli_query($conn, $sqla);
                        if ( $res ) {
                            echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
                   تم التحديث بنجاح
                  </div>';
                        } else {
                            echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
                    لم يتم التحديث بنجاح
                   </div>';
                        }     

        }
           
        
        
        
    }

//نهاية تحديث البيانات  

    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">اضافة قسم جديد</div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="name" class="col-sm-2 col-form-label">عنوان القسم</label>
                                            <div class="col-sm-10">
                                                <input value='<?php echo $row['name']; ?>' type="text" name="name" class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="detail" class="col-sm-2 col-form-label">التفاصيل</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="detail" id="detail" style="height: 150px"><?php echo $row['detail'];?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label"> صورة القسم</label>
                                                <input class="form-control" name="image" type="file" id="image">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button name="submit" type="submit" class="btn btn-primary text-end">تحديث</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </article>

            </div>
        </div>
    </form>
    <?php
    include "footer.php";

    ?>

</body>

</html>
//editnews
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php
    //اظهار البيانات القديمة
    if (isset($_GET['id'])) {
        include 'conn.php';
        
        $sqldata = "select * from news where id=" . $_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
    }
//نهاية اظهار البيانانت
//تحديث البيانات 
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $detail = $_POST['detail'];
    $date = $_POST['date'];

        $imageName='';

        if (file_exists($_FILES['image']['tmp_name'])) {
            $old_img_path="../admin/images/".$row['image'];
            unlink($old_img_path);
            $old_img_name=$_FILES['image']['name'];
            $expolad_name = explode(".", $_FILES['image']['name']);
            $ext = end($expolad_name); //get extinsion
            $imageName = "img" . time() . "." . $ext; //new image name
            move_uploaded_file($_FILES['image']['tmp_name'], '../admin/images/' . $imageName); //move image to bath

            $sql = "UPDATE `news` SET `title` = '$title',
            `detail` = '$detail',image='$imageName',`date` = '$date' WHERE `news`.`id` =" . $_GET['id'];
            $result = mysqli_query($conn, $sql);
            if ( $result ) {
                echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم التحديث بنجاح
      </div>';
            } else {
                echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم التحديث بنجاح
       </div>';
            }
        }else{
            $sqla="UPDATE `news` SET `title` = '$title',
            `detail` = '$detail' ,`date` = '$date' WHERE `news`.`id` =" . $_GET['id'];
                        $res = mysqli_query($conn, $sqla);
                        if ( $res ) {
                            echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
                   تم التحديث بنجاح
                  </div>';
                        } else {
                            echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
                    لم يتم التحديث بنجاح
                   </div>';
                        }     

        }
           
        
        
        
    }

//نهاية تحديث البيانات  

    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">تعديل الخبر</div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="title" class="col-sm-2 col-form-label">عنوان الخبر</label>
                                            <div class="col-sm-10">
                                                <input value='<?php echo $row['title']; ?>' type="text" name="title" class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="date" class="col-sm-2 col-form-label">تاريخ الخبر</label>
                                            <div class="col-sm-10">
                                                <input value='<?php echo $row['date']; ?>' type="text" name="date" class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="detail" class="col-sm-2 col-form-label">التفاصيل</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="detail" id="detail" style="height: 150px"><?php echo $row['detail'];?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label"> صورة الخبر</label>
                                                <input class="form-control" name="image" type="file" id="image">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button name="submit" type="submit" class="btn btn-primary text-end">تحديث</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </article>

            </div>
        </div>
    </form>
    <?php
    include "footer.php";

    ?>

</body>

</html>
//editstudents
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php
    //اظهار البيانات القديمة
    if (isset($_GET['id'])) {
        include 'conn.php';
        
        $sqldata = "select * from students where id=" . $_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
    }
//نهاية اظهار البيانانت
//تحديث البيانات 
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $dName = $_POST['dName'];


            $sql = "UPDATE `students` SET `name` = '$name',
            `email` = '$email',age='$age',`address` = '$address',`phone` = '$phone',`depnum` = '$dName' WHERE `students`.`id` =" . $_GET['id'];
            $result = mysqli_query($conn, $sql);
            if ( $result ) {
                echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم التحديث بنجاح
      </div>';
            } else {
                echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم التحديث بنجاح
       </div>';
            }
     
          
        }
           
        
        
        
    

//نهاية تحديث البيانات  

    ?>
   <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">تحديث طالب </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
      <form>
          <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">اسم الطالب</label>
              <div class="col-sm-10">
                  <input  value='<?php echo $row['name']; ?>' type="text" name="name" class="form-control" id="name">
              </div>
          </div>
          <div class="row mb-3">
              <label for="email" class="col-sm-2 col-form-label">الايميل</label>
              <div class="col-sm-10">
                  <input  value='<?php echo $row['email']; ?>' type="text" name="email" class="form-control" id="email">
              </div>
          </div>
          <div class="row mb-3">
              <label for="age" class="col-sm-2 col-form-label">العمر</label>
              <div class="col-sm-10">
                  <input  value='<?php echo $row['age']; ?>' type="text" name="age" class="form-control" id="age">
              </div>
          </div>
          <div class="row mb-3">
              <label for="phone" class="col-sm-2 col-form-label">الهاتف</label>
              <div class="col-sm-10">
                  <input  value='<?php echo $row['phone']; ?>' type="text" name="phone" class="form-control" id="phone">
              </div>
          </div>
          <div class="row mb-3">
              <label for="address" class="col-sm-2 col-form-label">العنوان</label>
              <div class="col-sm-10">
                  <input  value='<?php echo $row['address']; ?>' type="text" name="address" class="form-control" id="address">
              </div>
                                            <div class="row mb-3">
              <label for="dName" class="col-sm-2 col-form-label">القسم</label>
              <div class="col-sm-10">
                  <select type="text" name="dName" class="form-control" id="dName">
                      
                  <?php
                       include 'conn.php';
                      $sqldd = "SELECT id,name FROM department";
                      $res = mysqli_query($conn, $sqldd);
                      if (mysqli_num_rows($res) > 0) {
                          
                          while ($rooow=mysqli_fetch_assoc($res)) {
                      ?>
                      <option 
                      <?php if($rooow['id']== $row['depnum']) {?>
                          selected="selected" <?php } ?> value='<?php echo $rooow['id']; ?>'>
                          <?php echo $rooow['name']; ?>
                      </option>                                                      
                        <?php  }
                      }?>
                  </select>
              </div>
          </div>
          <!-- <select class="form-select" aria-label="Default select example">
                  <option selected>اختر التخصص</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                                </select> -->

                    </form>
                </div>

            </div>

        </div>
        <div class="d-flex justify-content-end">
            <button name="submit" type="submit" class="btn btn-primary text-end">تحديث</button>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </form>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//editusers
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php

    //اظهار البيانات القديمة
    if (isset($_GET['id'])) {
        include 'conn.php';

        $sqldata = "select * from users where id=" . $_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
    }
    //نهاية اظهار البيانانت
    //تحديث البيانات 
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (isset($_POST['isAdmin'])) {
            $type = 1;
        } else {
            $type = 0;
        }
        $sql = "UPDATE `users` SET `username` = '$username',
            `password` = '$password',isAdmin='$type' where `id` =" . $_GET['id'];
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم التحديث بنجاح
      </div>';
        } else {
            echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم التحديث بنجاح
       </div>';
        }

    }






    //نهاية تحديث البيانات  

    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">تحديث المستخدم </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="username" class="col-sm-2 col-form-label">اسم المستخدم</label>
                                            <div class="col-sm-10">
                                                <input value='<?php echo $row['username']; ?>' type="text" name="username" class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password" class="col-sm-2 col-form-label">كلمة السر</label>
                                            <div class="col-sm-10">
                                                <input value='<?php echo $row['password']; ?>' type="text" name="password" class="form-control" id="email">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="isAdmin" class="col-sm-2 col-form-label">هل المستخدم مدير؟</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" value="1" <?php if ($row['isAdmin'] == 1) {
                                                                                        echo 'checked';
                                                                                    } ?> name="isAdmin" class="form-chexk-input" id="isAdmin">
                                            </div>
                                        </div>


                                        </select>
                                </div>
                            </div>


    </form>
    </div>

    </div>

    </div>
    <div class="d-flex justify-content-end">
        <button name="submit" type="submit" class="btn btn-primary text-end">تحديث</button>
    </div>
    </div>
    </article>

    </div>
    </div>
    </form>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//footer
<!--start footer-->
<footer>
      <div class="container">
          <div class="row pt-2 bg-secondary d-flex align-items-center">
              <div class="col-md-6 ">
                  <h3>المركز الفلسطيني للتعليم التقني</h3>
              </div>
              <div class="col-md-6">
                  <div class="fs-1 text-center">
                      <a href="#"><i class="bi bi-instagram "></i></a>
                      <a href="#"><i class="bi bi-facebook"></i></a>
                      <a href="#"><i class="bi bi-twitter"></i></a>
                      <a href="#"><i class="bi bi-google"></i></a>
                  </div>
              </div>

          </div>
      </div>
  </footer>
  <script src="../js/javascript.js"></script>
  <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>
    <!--end footer-->
//header

<!--start headr-->
<header class="container " >
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" >
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">تطبيقات الويب</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu.php">عن المركز</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dep.php">اتصل بنا</a>
                        </li>
                        <li class="nav-item dropdown">

                        </li>

                    </ul>
                    <div class=" position-relative navbar-nav">
                        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            الاعدادات
                        </a>
                        <?php 
                        if(isset($_SESSION['id'])){
                            echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="cp.php">لوحة التحكم</a></li>
                            <li><a class="dropdown-item" href="logout.php"> تسجيل خروج</a></li>
                            <li><a class="dropdown-item" href="admininsert.php"> تسجيل مستخدم جديد</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>';}
                        else{
                            echo'<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="cp.php">لوحة التحكم</a></li>
                         
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>';
                        }
                        

                        ?>
                        
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <div class="row bg-primary text-center py-2">
            <h2>المركز الفلسطيني للتعليم التقني</h2>
        </div>
    </div>
</main>
<!--end header -->
//index
<!DOCTYPE html>
<html lang="ar" dir="rtl">
 

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>test1</title>
    <link rel="stylesheet" href="css/style.css" />

</head>
<!-- خلي الcss internal  -->
<body>
    <header class="header" id="header">
        <img src="images/logo.png" alt="logo" />
        <ul>
            <li><a href="#">الرئيسية</a></li>
            <li><a href="#">حول الموقع</a></li>
            <li><a href="#">الاخبار</a></li>
            <li><a href="#">معلومات الاتصال</a></li>
            <li><a href="login.php">تسجيل دخول</a></li>
        </ul>
    </header>
    <section class="landing" id="landing">
        <div class="landing-content">
            <h1 class="title">عنوان الشريحة رقم 1</h1>
            <div class="desc">
                <p>
                    تفاصيل الشريحة تفاصيل الشريحة تفاصيل الشريحة تفاصيل الشريحة تفاصيل
                    الشريحة تفاصيل الشريحة تفاصيل الشريحة تفاصيل الشريحة تفاصيل الشريحة
                    تفاصيل الشريحة تفاصيل الشريحة
                </p>
            </div>
            <a href="#">تفاصيل</a>
        </div>
    </section>
   
    <section class="news" id="news">
        <div class="section-title">
            <h2>الاخبار</h2>
        </div>
        <div class="news-content">




            <?php
            include 'conn.php';
            $sql = "select * from news ";
     //       $sql = "select * from news limit 2";for limt

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '  <div class="col">
                  <img style="width: 400px; height: 300px;" src="images/'.$row['image'].'" alt="" srcset="">
                  <div class="news-title">
                      <h3>'.$row['title'].'</h3>
                  </div>
                  <div class="more-hover">
                   
                      <h6><a href="newsdetail.php?id='.$row['id'].'" >المزيد</a></h6>
                  </div>
              </div>
  ';
                }
            }

            ?>


















        </div>
    </section>
<main></main>
</body>


</html>
//login
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>
    <?php
    include "header.php";
    include "conn.php"
    ?>
    <?php
    $msg = "";
    if (isset($_POST['submit'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];
        if (empty($username)) {
            $msg = "<div class='alert alert-danger'role='alert'>
            الرجاء ادخال اسم المستخدم</div>
            ";
        } elseif (empty($_POST['password'])) {
            $msg = "<div class='alert alert-danger'role='alert'>
                الرجاء ادخال كلمة المرور</div>
                ";
        } else {
            $sql = "select * from users where username='$username' and password ='$password'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 0) {
                $msg = "<div class='alert alert-danger'role='alert'>
            خطا في اسم المستخدم او كلمة المرور</div>
            ";
            } else {

                $user = mysqli_fetch_assoc($result);


                $_SESSION['id'] = $user['id'];
                $_SESSION['user'] = $user['username'];
                header('Location:cp.php');
            }
        }
    }

    ?>
    <form action="" method="post">
        <div class="card container">
            <div class="card-header text-center">
                <h4>تسجيل الدخول للوحة التحكم</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <?php echo $msg ?>

                    <div class="col">
                        <label for="user-name">اسم المستخدم</label><br> <br> <br>
                        <label for="password">كلمة السر</label>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="username" placeholder="اسم المستخدم"><br>
                        <input type="password" class="form-control" name="password" placeholder="كلمة المرور"><br>
                        <button type="submit" class="btn btn-primary" name="submit">Sign in</button>

                    </div>

                </div>
            </div>
    </form>

    <?php
    include "footer.php";
    ?>

</body>

</html>
//logout
<?php
session_start();
if(isset($_SESSION['id'])){
    session_destroy();
    header('location:login.php');
}

?>
//menu
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
   

</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <div class=" row container" style="min-height: 320px; margin-right:110px;" >
        <div class="card col-md-12">
            <div class="card-header text-right">عن المركز</div>
            <div class="card-body text-right" style="height: 200px;">
         Lorem ipsum dolor sit, amet consectetur adipi
         sicing elit. Magnam adipisci veniam natus quo aperiam 
         odit. Quas veritatis corporis incidunt doloremque rerum inventore 
          excepturi, expedita laboriosam aliquid? Omnis, eos veniam.
         </div>
        </div>
        </div>
      
    <?php
    include "footer.php";
    ?>
</body>

</html>
//menudelet
<?php
include ('conn.php');

// start delte images

$sqldata = "select * From menu where id=" .$_GET['id'];
        $resultQury = mysqli_query($conn, $sqldata);
        $row = mysqli_fetch_assoc($resultQury);
       
      
       
// end delte images

$sql="delete From menu where id=".$_GET["id"];
$res=mysqli_query($conn,$sql);
header("location:test1.php");

?>
//newsdetail
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التفاصبل
    </title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
</head>
<?php
if (isset($_GET['id'])) {
  include "conn.php";
  $deptDelet = "SELECT * FROM news where id =" . $_GET['id'];
  $res  = mysqli_query($conn, $deptDelet);
  $row = mysqli_fetch_assoc($res);
}
?>
<body>
    <section>
        <div class="container">
            <div class="row">
                <h1 class="text-center bg-successs py-1 bg-success text-light">hello</h1>
            </div>
            
            <div class="row text-center">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center"><?php if (isset($row['title'])) echo $row['title']; ?></h4>
                    </div>
                    <div class="card-body">
                    <?php if (isset($row['image'])) echo '<img src="../admin/images/' . $row['image'] . '" alt="' . $row['image'] . '" height="300px">'; ?>                        <div class="row"> 
                            <h1><?php if (isset($row['detail'])) echo $row['detail']; ?></h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="js\bootstrap.min.js"></script>

</body>

</html>
//newsinsert
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <?php
    //insert dep data
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $detail = $_POST['detail'];
        $date = $_POST['date'];

        if (file_exists($_FILES['image']['tmp_name'])) {

            $expolad_name = explode(".", $_FILES['image']['name']);
            $ext = end($expolad_name); //get extinsion
            $imageName = "img" . time() . "." . $ext; //new image name
            move_uploaded_file($_FILES['image']['tmp_name'], '../admin/images/' . $imageName); //move image to bath

            $sql = "insert into news(title,detail,date,image) values('$title','$detail','$date','$imageName')";
            include 'conn.php';
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم الاضافة بنجاح
      </div>';
            } else {
                echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم الاضافة بنجاح
       </div>';
            }
        }
    }


    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">اضافة خبر جديد</div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="title" class="col-sm-2 col-form-label">عنوان الخبر</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" class="form-control" id="title">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="date" class="col-sm-2 col-form-label">تاريخ الخبر</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="date" class="form-control" id="date">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="detail" class="col-sm-2 col-form-label">التفاصيل</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="detail" id="detail" style="height: 150px"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label"> صورة الخبر</label>
                                                <input class="form-control" name="image" type="file" id="image">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button name="submit" type="submit" class="btn btn-primary text-end">اضافة خبر</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </article>

            </div>
        </div>
    </form>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//newsshow
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
    <div class="container">
        <div class="row br-light" style="margin-top:80px">
            <?php include 'sidebar.php' ?>
            <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                <div class="card">
                    <div class="card-header text-center">الاخبار</div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table text-center">
                                    <thead>
                                        <tr style="vertical-align: middle;">
                                            <th scope="col">#</th>
                                            <th scope="col">عنوان الخبر</th>
                                            <th scope="col">تاريخ الخبر</th>
                                            <th scope="col">تفاصيل الخبر</th>

                                            
                                            <th scope="col">صورة الخبر</th>
                                            <th scope="col">حذف</th>
                                            <th scope="col">تعديل</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr style="vertical-align: middle;">
                                            <th scope="row">1</th>
                                            <td>تطبيقات الويب</td>
                                            <td><img width="100px" src="../admin/images/img1.png" alt=""></td>
                                            <td><a href="#" class=" btn btn-danger">edit</a></td>
                                            <td><a href="#" class=" btn btn-danger">delete</a></td>

                                        </tr>
                                        <tr style="vertical-align: middle;">
                                            <th scope="row">1</th>
                                            <td>تطبيقات الموبيال</td>
                                            <td><img width="100px" src="../admin/images/img1.png" alt=""></td>
                                            <td><a href="#" class=" btn btn-danger">edit</a></td>
                                            <td><a href="#" class=" btn btn-danger">delete</a></td>

                                        </tr> -->
                                        <?php include 'conn.php';
                                        $sql = "select * from news";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $key = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr style="vertical-align: middle;">
                                                <th scope="row">' . $key . '</th>
                                                <td>' . $row['title'] . '</td>
                                                <td>' . $row['date'] . '</td>
                                                <td>' . $row['detail'] . '</td>

                                                <td><img width="100px" src="../admin/images/' . $row['image'] . '" alt="' . $row['title'] . '"></td>
                                                <td>'.' <a  href="deletenews.php?id='.$row["id"].'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg></a>'.'</td>
                                                <td>'.' <a  href="editnews.php?id='.$row["id"].'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                </a>'.'</td>
                                                
                                                </tr>
    
                                            </tr>';
                                                $key++;
                                            }
                                        } else {
                                            echo '<td colspan="7"><div style=" text-align: center;" class="alert alert-info" role="alert">
                                          لايوجد بيانات لعرضها 
                                        </div></td>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3 text-center">
                               <a href="newsinsert.php"><button type="button" class="btn btn-info">اضافة خبر</button></a> 

                            </div>
                        </div>

                    </div>

                </div>
            </article>

        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>
//sidebar
<aside class="col-lg-3 text-right bg-light" style="background: dimgray;">
    <div class="list-group" style="min-height: 425px;">
    <a href="cp.php" class="list-group-item"><h5>لوحة التحكم</h5></a>
    <a href="depshow.php" class="list-group-item"><h5>الاقسام</h5></a>
    <a href="menushow.php" class="list-group-item"><h5>القائمة</h5></a>
    <a href="newsshow.php" class="list-group-item"><h5>الاخبار</h5></a>
    <a href="studentshow.php" class="list-group-item"><h5>الطلاب</h5></a>
    <a href="adminshow.php" class="list-group-item"><h5>مدراء الموقع</h5></a>

    </div>
    </aside>
    //start
    <!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->



    <div class="container">
        <div class="row">
            <?php
            include 'conn.php';
            $sql = "select * from news ";
            //       $sql = "select * from news limit 2";for limt

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                   
                }
            }

            ?>
              <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/<?php $row['image']?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/logo.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/phone.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</body>

</html>
//studentinsert
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
 
    <?php
    //insert dep data
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $dName = $_POST['dName'];
        $sql = "insert into students(name,email,age,address,phone,depnum) values('$name','$email','$age','$address','$phone','$dName')";
        include 'conn.php';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo '<div style=" text-align: center;" class="alert alert-success" role="alert">
       تم الاضافة بنجاح
      </div>';
        } else {
            echo '<div style=" text-align: center;" class="alert alert-danger" role="alert">
        لم يتم الاضافة بنجاح
       </div>';
        }
    }


    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row br-light" style="margin-top:80px">
                <?php include 'sidebar.php' ?>
                <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                    <div class="card">
                        <div class="card-header text-right">اضافة طالب جديد</div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <form>
                                        <div class="row mb-3">
                                            <label for="name" class="col-sm-2 col-form-label">اسم الطالب</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="email" class="col-sm-2 col-form-label">الايميل</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="email" class="form-control" id="email">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="age" class="col-sm-2 col-form-label">العمر</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="age" class="form-control" id="age">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="phone" class="col-sm-2 col-form-label">الهاتف</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="phone" class="form-control" id="phone">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="address" class="col-sm-2 col-form-label">العنوان</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="address" class="form-control" id="address">
                                            </div>

                                            <div class="row mb-3">
                                                <label for="dName" class="col-sm-2 col-form-label">القسم</label>
                                                <div class="col-sm-10">
                                                    <select type="text" name="dName" class="form-control" id="dName">
                                                        
                                                    <?php
                                                         include 'conn.php';
                                                        $sqldd = "SELECT id,name FROM department";
                                                        $res = mysqli_query($conn, $sqldd);
                                                       
                                                        if (mysqli_num_rows($res) > 0) {
                                                            
                                                            while ($rooow=mysqli_fetch_assoc($res)) {
                                                               
                                                                echo '<option value="'.$rooow['id'].'">'.$rooow['name'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <select class="form-select" aria-label="Default select example">
                                                    <option selected>اختر التخصص</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select> -->

                                    </form>
                                </div>

                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button name="submit" type="submit" class="btn btn-primary text-end">اضافة طالب</button>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </form>
    <?php
    include "footer.php";
    ?>
</body>

</html>
//studentshow
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">
</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>


    <div class="container">

        <?php

        ?>
        <div class="row br-light" style="margin-top:80px">
            <?php include 'sidebar.php' ?>
            <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                <div class="card">
                    <div class="col-md-3 text-end">

                    </div>
                    <div class="col-md-3 text-end">

                    </div>
                    <div class="card-header text-center d-flex justify-content-between  align-items-center">

                        الطلاب
                        <a href="studentinsert.php"><button type="button" class="btn btn-info ">اضافة طالب</button></a>

                    </div>


                    <div class="card-body ">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col">
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-2 col-form-label">بحث</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" id="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <button name="submit" type="submit" class="btn btn-primary text-end">بحث</button>

                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table text-center">
                                    <thead>
                                        <tr style="vertical-align: middle;">
                                            <th scope="col">#</th>
                                            <th scope="col">الاسم</th>
                                            <th scope="col">الايميل</th>
                                            <th scope="col">العمر</th>
                                            <th scope="col">العنوان</th>
                                            <th scope="col">تلفون</th>
                                            <th scope="col">القسم</th>
                                            <th scope="col">حذف</th>
                                            <th scope="col">تعديل</th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php include 'conn.php';
                                        if (isset($_POST['submit'])) {
                                            $name = $_POST['name'];
                                            $sql = "select students.id,students.name ,students.email,students.age,students.address,students.phone,department.id as dId,department.name as dName from students join department on students.depnum=department.id where students.name like'%$name%'";
                                        } else {
                                            $sql = "select students.id,students.name ,students.email,students.age,students.address,students.phone,department.id as dId,department.name as dName from students join department on students.depnum=department.id";
                                        }
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $key = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr style="vertical-align: middle;">
                                                <th scope="row">' . $key . '</th>
                                                <td>' . $row['name'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['age'] . '</td>
                                                <td>' . $row['address'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                                <td>' . $row['dName'] . '</td>

                                               
                                                <td>' . ' <a   href="deletestudent.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg></a>' . '</td>
                                                <td>' . ' <a  href="editstudent.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                </a>' . '</td>
                                                
                                                </tr>
    
                                            </tr>';
                                                $key++;
                                            }
                                        } else {
                                            echo '<td colspan="7"><div style=" text-align: center;" class="alert alert-info" role="alert">
                                          لايوجد بيانات لعرضها 
                                        </div></td>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </article>

        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>
//studentserch
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
//لازم يكون في اعلى الصفحة دائما

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">


<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\bootstrap.rtl.min.css">


</head>

<body>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <script src="js\bootstrap.min.js"></script>

    <?php
    include "header.php";
    ?>
   
 
    <div class="container">
       
        <?php

        ?>
        <div class="row br-light" style="margin-top:80px">
            <?php include 'sidebar.php' ?>
            <article class="col-lg-9" style="min-height: 320px;background: rgba(.8,.3,0,.05);">
                <div class="card">
                    <div class="col-md-3 text-end">

                    </div>
                    <div class="card-header text-center">

                        الطلاب

                    </div>


                    <div class="card-body ">
                    <form action="" method="post">
    <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">بحث</label>
                    <div class="col-sm-10">
                        <input value="<?php echo $row['name'];?>" type="text" name="name" class="form-control" id="name">
                    </div>
                </div>
            </div>
            <div class="col">
                <button name="submit" type="submit" class="btn btn-primary text-end">بحث</button>

            </div>
        </div>
    </form>
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table text-center">
                                    <thead>
                                        <tr style="vertical-align: middle;">
                                            <th scope="col">#</th>
                                            <th scope="col">الاسم</th>
                                            <th scope="col">الايميل</th>
                                            <th scope="col">العمر</th>
                                            <th scope="col">العنوان</th>
                                            <th scope="col">تلفون</th>
                                            <th scope="col">القسم</th>
                                            <th scope="col">حذف</th>
                                            <th scope="col">تعديل</th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php include 'conn.php';
                                        if (isset($_POST['submit'])) {
                                            $name = $_POST['name'];
                                            $sql = "select students.id,students.name ,students.email,students.age,students.address,students.phone,department.id as dId,department.name as dName from students join department on students.depnum=department.id where students.name like'%$name%'";
                                        } else {
                                            $sql = "select students.id,students.name ,students.email,students.age,students.address,students.phone,department.id as dId,department.name as dName from students join department on students.depnum=department.id";
                                        }
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            $key = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr style="vertical-align: middle;">
                                                <th scope="row">' . $key . '</th>
                                                <td>' . $row['name'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['age'] . '</td>
                                                <td>' . $row['address'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                                <td>' . $row['dName'] . '</td>

                                               
                                                <td>' . ' <a  href="deletestudent.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                </svg></a>' . '</td>
                                                <td>' . ' <a  href="editstudent.php?id=' . $row["id"] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                                </a>' . '</td>
                                                
                                                </tr>
    
                                            </tr>';
                                                $key++;
                                            }
                                        } else {
                                            echo '<td colspan="7"><div style=" text-align: center;" class="alert alert-info" role="alert">
                                          لايوجد بيانات لعرضها 
                                        </div></td>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </article>
           
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>
//
//كود الاستاذ احمد الجديد
<?php
// connecting in database
$conn = mysqli_connect("localhost", "root", "", "center_db");
if (!$conn) {
  die("No connect" . mysqli_connect_errno());
}

// insert  data with image|file
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $detail = $_POST['detail'];
  if (file_exists($_FILES['image']['tmp_name'])) {
    $old_img_name = $_FILES['image']['name'];
    $expload_name = explode(".", $old_img_name);
    $ext = end($expload_name);
    $imageName = "img" . time() . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/dep/' . $imageName);
    $sql = "insert into department (name,detail,image) values ('$name','$detail','$imageName')";
    include "conn.php";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $msg = '<div class="alert alert-success" role="alert">
                تمت عملية الاضافة بنجاح
              </div>';
    } else {
      $msg = '<div class="alert alert-danger" role="alert">
                لم تتم عملية الاضافة بنجاح
              </div>';
    }

    mysqli_close($conn);
  }
}

// insert data without image|file
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $detail = $_POST['detail'];
  $sql = "insert into department (name,detail) values ('$name','$detail')";
  include "conn.php";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $msg = '<div class="alert alert-success" role="alert">
      تمت عملية الاضافة بنجاح
    </div>';
  } else {
    $msg = '<div class="alert alert-danger" role="alert">
      لم تتم عملية الاضافة بنجاح
    </div>';
  }

  mysqli_close($conn);
}

// show data using table with while 
include "conn.php";
$sql = "select * from department";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $key = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    echo '
        <tr class="align-middle">
          <th scope="row">' . ++$key . '</th>
          <td>' . $row['name'] . '</td>
          <td><img width="100px" src="../images/dep/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
          <td><a href="depedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
          <td><a href="depdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
        </tr>
        
        ';
  }
} else {
  echo '<tr class="align-middle">
     <td colspan="5" scope="row">لا يوجد بيانات يمكن عرضها...</td>
 </tr>';
}

// show data with foreach
include "conn.php";
$sql = "select * from department";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  foreach ($result as $key => $row) {
    echo '
    <tr class="align-middle">
      <th scope="row">' . ++$key . '</th>
      <td>' . $row['name'] . '</td>
      <td><img width="100px" src="../images/dep/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
      <td><a href="depedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
      <td><a href="depdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
    </tr>
    
    ';
  }
} else {
  echo '<tr class="align-middle">
     <td colspan="5" scope="row">لا يوجد بيانات يمكن عرضها...</td>
 </tr>';
}
//show data from two table
include "conn.php";
	$sql = "select students.id,students.name,students.email,students.age,
	students.address,students.phone,department.id as dId,department.name as dName
	from students join department on students.depnum=department.id ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$key = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			echo '
				<tr class="align-middle">
					<th scope="row">' . ++$key . '</th>
					<td>' . $row['name'] . '</td>
					<td>' . $row['email'] . '</td>
					<td>' . $row['age'] . '</td>
					<td>' . $row['address'] . '</td>
					<td>' . $row['phone'] . '</td>
					<td>' . $row['dName'] . '</td>
					<td><a href="studentedit.php?id='.$row['id'].'" class="btn btn-danger">edit</a></td>
					<td><a href="studentdelete.php?id='.$row['id'].'" class="btn btn-danger">delete</a></td>
				</tr>
			';
		}
	} else {
		echo '<tr class="align-middle">
		 <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
	 </tr>';
	}
//search from data in database
		include "conn.php";
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$sql = "select students.id,students.name,students.email,students.age,
		students.address,students.phone,department.id as dId,department.name as dName
		from students join department on students.depnum=department.id
		where students.name like '%$name%' ";
		} else {
			$sql = "select students.id,students.name,students.email,students.age,
		students.address,students.phone,department.id as dId,department.name as dName
		from students join department on students.depnum=department.id ";
		}

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$key = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				echo '
					<tr class="align-middle">
						<th scope="row">' . ++$key . '</th>
						<td>' . $row['name'] . '</td>
						<td>' . $row['email'] . '</td>
						<td>' . $row['age'] . '</td>
						<td>' . $row['address'] . '</td>
						<td>' . $row['phone'] . '</td>
						<td>' . $row['dName'] . '</td>
						<td><a href="studentedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
						<td><a href="studentdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
					</tr>
				';
			}
		} else {
			echo '<tr class="align-middle">
			 <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
		 </tr>';
		}
//show data in select 
 <select class="form-select" name="dName" aria-label="Default select example">
	<?php
	include "conn.php";
	$sql = "select id,name from department";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($drow = mysqli_fetch_assoc($result)) {
	?>
			<option 
			<?php if ($drow['id'] == $row['depnum']) { ?> 
				selected="selected" 
				<?php } ?> 
				value='<?php echo $drow['id']; ?>'>
				<?php echo $drow['name'];  ?>
			</option>

	<?php }
	} ?>
</select>
//SLIDER BY FOREACH
<div class="row">
                <?php
                include "admin/conn.php";
                $sql = "select * from news";
                $result = mysqli_query($conn, $sql);

                ?>
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $key => $row) {
                        ?>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $key ?>" class="<?php if ($key == 0) echo 'active' ?>" aria-current="true" aria-label="Slide <?php echo ++$key ?>"></button>

                        <?php
                            }
                        }
                        ?>


                    </div>
                    <div class="carousel-inner">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $key => $row) {
                        ?>
                                <div class="carousel-item <?php if ($key == 0) echo 'active' ?>">
                                    <img src="images/<?php echo $row['image'] ?>" class="d-block w-100" alt="<?php echo $row['title'] ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?php echo $row['title'] ?></h5>
                                        <p><?php echo $row['detail'] ?></p>
                                    </div>
                                </div>

                        <?php
                            }
                        }
                        ?>



                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

//edit data with image|file
if (isset($_GET['id'])) {
  include "conn.php";
  $sqlGetDepData = "select * from department where id=" . $_GET['id'];
  $result = mysqli_query($conn, $sqlGetDepData);
  $row = mysqli_fetch_assoc($result);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    if (file_exists($_FILES['image']['tmp_name'])) {
      $old_img_path = "../images/" . $row['image'];
      unlink($old_img_path);
      $new_img_name = $_FILES['image']['name'];
      $expload_name = explode(".", $new_img_name);
      $ext = end($expload_name);
      $imageName = "img" . time() . "." . $ext;
      move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $imageName);
      $sql = "update department set name='$name',detail='$detail',image='$imageName' where id=" . $_GET['id'];
      $res = mysqli_query($conn, $sql);
      header('location:depshow.php?success=true');
      exit();
    } else {

      $sql = "update department set name='$name',detail='$detail' where id=" . $_GET['id'];
      $res = mysqli_query($conn, $sql);
      header('location:depshow.php?success=true');
      exit();
    }
  }
}v

// edit data without image
if (isset($_GET['id'])) {
  include "conn.php";
  $sqlGetDepData = "select * from department where id=" . $_GET['id'];
  $result = mysqli_query($conn, $sqlGetDepData);
  $row = mysqli_fetch_assoc($result);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $sql = "update department set name='$name',detail='$detail',image='$imageName' where id=" . $_GET['id'];
    $res = mysqli_query($conn, $sql);
    header('location:depshow.php?success=true');
    exit();
  }
}

// delete data with image|file
if (isset($_GET['id'])) {
  include 'conn.php';
  $querySelect = 'select * from department where id=' . $_GET['id'];
  $ResultSelectStmt = mysqli_query($conn, $querySelect);
  $fetchRecords = mysqli_fetch_assoc($ResultSelectStmt);
  $createDeletePath  = '../images/' . $fetchRecords['image'];
  if (unlink($createDeletePath)) {
    $sql = "delete from department where id=" . $_GET["id"];
    $rsDelete = mysqli_query($conn, $sql);
    if ($rsDelete) {
      header('location:depshow.php?success=true');
      exit();
    }
  }
}
// delete data without image|file
if (isset($_GET['id'])) {
  include 'conn.php';
  $sql = "delete from department where id=" . $_GET["id"];
  $rsDelete = mysqli_query($conn, $sql);
  if ($rsDelete) {
    header('location:depshow.php?success=true');
    exit();
  }
}
// logout code
session_start();
if (isset($_SESSION['id'])) {
  session_destroy();
  header('location:login.php');
}

// login code 
$msg = "";
if (isset($_POST['submit'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['password'];
  if (empty($username)) {
    $msg = "<div class='alert alert-danger' role='alert'>
      الرجاء ادخال اسم المستخدم
     </div>";
  } elseif (empty($_POST['password'])) {
    $msg = "<div class='alert alert-danger' role='alert'>
    الرجاء ادخال كلمة المرور
   </div>";
  } else {
    include "conn.php";
    $sql = "select * from users where username='$username' and password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      $msg = "<div class='alert alert-danger' role='alert'>
        خطأ في اسم المستخدم و كلمة المرور
       </div>";
    } else {
      $user = mysqli_fetch_assoc($result);
      $_SESSION['id'] = $user['id'];
      header('Location:home.php');
    }
  }
}

// check user is login!
//put this code in all page 
session_start(); 
if (!isset($_SESSION['id'])) {

  header('Location:login.php');
}

//show data from select 

 <select name="book_categories " id="inputCategory" class="form-select">
	<?php
	include "config.php";
	$sql = "select * from category";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
	  foreach ($result as $key => $row) {
		echo '
		<option value="'.$row['id'].'">'.$row['title'].'</option>
		
		';
	  }
	} 
	
	?>

   
  </select>
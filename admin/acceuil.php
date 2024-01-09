<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:../authentification.php");
}
?>
<title>Acceuil</title>

<?php 
include_once "nav_bar.php";
?>

<div class="main-panel">
<div class="content-wrapper">
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span> Accueil
    </h3>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
        </li>
      </ul>
    </nav>

  </div>
  

    <span class="text-center mt-5" id="element"></span>

<script src="../node_modules/typed.js/dist/typed.umd.js"></script>
<script>
  var typed = new Typed('#element', {
    strings: ['<h4>﴾ يَاأَيُّهَا الَّذِينَ آمَنُوا لَا تَسْأَلُوا عَنْ أَشْيَاءَ إِنْ تُبْدَ لَكُمْ تَسُؤْكُمْ  وَإِنْ تَسْأَلُوا عَنْهَا حِينَ يُنَزَّلُ الْقُرْآنُ تُبْدَ لَكُم عَفَا اللَّهُ عَنْهَا وَاللَّهُ غَفُورٌ حَلِيمٌ ﴿</h4>'],
    typeSpeed: 10,
    // loop: true,
  });
</script>
</div>
</div>

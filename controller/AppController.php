<?php
class AppController extends Controller
{
//	public $content_for_layout;

	public function appCamagru(){
		$this->loadModel('User');
//		phpinfo();
		if ($_SESSION['log'] == 1){
			if (isset($_POST['logout']) && $_POST['logout'] === 'Logout'){
				session_destroy();
				?>
				<script type="text/javascript">document.location.href="<?php
						echo BASE_URL.DS.'controller'.DS.'AccueilController' ?>";
				</script>
				<?php
//				header('Location: '.BASE_URL.DS.'index.php');
//				exit();
//				$this->redirection('Accueil', 'accueil');
			}
			$this->render('appCamagru', 'app_layout');
		}else{
			$this->redirection('Accueil', 'accueil');
		}

	}
}
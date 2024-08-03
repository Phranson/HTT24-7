<?php
class DashboardController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['userRole'])) {
            $role = $_SESSION['userRole'];
            switch ($role) {
                case '1':
                    $this->view('staff/dashboard');
                    break;
                case '2':
                    $this->view('visitor/dashboard');
                    break;
                case '3':
                    $this->view('client/dashboard');
                    break;
                default:
                    $this->view('error/unauthorized');
                    break;
            }
        } else {
            header("Location: login.php");
            exit();
        }
    }
}

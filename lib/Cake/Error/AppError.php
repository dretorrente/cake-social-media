<?php
class AppError extends ErrorHandler {
    function missingAction($parameters) {
        $this->controller->redirect('/dashboard');
    }
}
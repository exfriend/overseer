myApp.controller('TasksController', function ($scope, $interval, $messenger, $taskService) {
    angular.element(document).ready(function () {

        $scope.tasks_running = 0;

        /*
         Start, Stop, Unlock
         */

        $scope.start = $taskService.startTask;
        $scope.stop = $taskService.stopTask;
        $scope.unlock = $taskService.unlockTask;

        /*
         Get the tasks
         */
        $scope.getTasks = function () {
            $scope.tasks = $taskService.getTasks();
            $scope.tasks_running = $taskService.countRunning();
        }

        /*
         Initialization
         */
        $messenger.clearMessages();
        $scope.getTasks();

        //$taskService.startTask(1);

        /*
         Periodic
         */
        $interval($scope.getTasks, 2000)
        $interval($messenger.getMessages, 2000)


    });
});
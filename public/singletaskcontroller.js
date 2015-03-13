myApp.controller('SingleTaskController', function ($scope, $interval, $sce, $messenger, $taskService) {
    angular.element(document).ready(function () {


        $scope.task = {id: 0, short_log: "no logs"};
        $scope.singleTaskId;

        $scope.start = function () {
            $taskService.startTask($scope.singleTaskId);
        };

        $scope.stop = function () {
            $taskService.stopTask($scope.singleTaskId);
        };

        $scope.unlock = function () {
            $taskService.unlockTask($scope.singleTaskId);
        };

        $scope.getTaskInfo = function () {
            $scope.task = $taskService.getTaskInfo($scope.singleTaskId);
            $scope.task.short_log = $sce.trustAsHtml($scope.task.short_log);
        }

        /*
         Initialization
         */


        //$taskService.startTask(1);

        /*
         Periodic
         */
        $interval($scope.getTaskInfo, 1000)

    });
});
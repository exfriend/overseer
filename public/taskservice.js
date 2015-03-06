myApp.service('$taskService', function ($http) {

    var self = this;
    this.tasks = [];
    this.tasks_running = 0;

    /*
     Count tasks
     */
    this.countRunning = function () {
        self.tasks_running = 0;
        angular.forEach(self.tasks, function (task) {
            self.tasks_running += task.running;
        });

        return self.tasks_running;
    }

    /*
     Get tasks
     */
    this.getTasks = function () {
        $http.get(domain_root + '/api/tasks/all').success(function (data) {
            self.tasks = data;
        });

        this.countRunning();

        return self.tasks;
    };
    /*
     Get task info
     */
    this.getTaskInfo = function (taskId) {
        var self = this;

        $http.get(domain_root + '/api/tasks/' + taskId).success(function (data) {
            self.singleTask = data;
        });

        return self.singleTask;
    };


    /**
     Start task
     */
    this.startTask = function (taskId) {
        $http.get(domain_root + '/api/tasks/' + taskId + '/start').success(this.getTasks);
    }

    /**
     Stop task
     */
    this.stopTask = function (taskId) {
        $http.get(domain_root + '/api/tasks/' + taskId + '/stop').success(this.getTasks);
    }
    /**
     Unlock task
     */
    this.unlockTask = function (taskId) {
        $http.get(domain_root + '/api/tasks/' + taskId + '/unlock').success(this.getTasks);
    }


});

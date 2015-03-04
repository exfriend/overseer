function setProgress(task_id, val) {

    $(".data-progress[data-task-id=" + task_id + "]").css('width', val + '%');
    $(".data-progress[data-task-id=" + task_id + "]").attr('aria-valuenow', val);
}


function setLog(task_id, val) {
    $(".data-log[data-task-id=" + task_id + "]").html(val);
}


function setRunning(task_id) {

    $(".data-btn_start[data-task-id=" + task_id + "]").addClass('disabled');
    $(".data-btn_stop[data-task-id=" + task_id + "]").removeClass('disabled');
}

function setStopped(task_id) {

    $(".data-btn_stop[data-task-id=" + task_id + "]").addClass('disabled');
    $(".data-btn_start[data-task-id=" + task_id + "]").removeClass('disabled');
}


function setRunningAlt(task_id) {

    $(".data-btn_start[data-task-id=" + task_id + "]").hide();
    $(".data-btn_stop[data-task-id=" + task_id + "]").show();
}

function setStoppedAlt(task_id) {

    $(".data-btn_stop[data-task-id=" + task_id + "]").hide();
    $(".data-btn_start[data-task-id=" + task_id + "]").show();
}

function unlockAlt(task_id) {

    $(".data-btn_unlock[data-task-id=" + task_id + "]").hide();
}


function task_control(id, act) {

    if (act == 'start') {
        setRunning(id);
    }
    else {
        setStopped(id);
    }

    $.get(api_url + id + "/" + act, null);

}
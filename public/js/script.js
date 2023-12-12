//navbar active
$(".sidebar ul li").on('click', function () {
    $(".sidebar ul li.active").removeClass('active');
    $(this).addClass('active');
});

$('.open-btn').on('click', function () {
    $('.sidebar').addClass('active');

});


$('.close-btn').on('click', function () {
    $('.sidebar').removeClass('active');

})

//tables
$(document).ready(function() {
    $('#myDataTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: false,
});
});

$(document).ready(function() {
    $('#myInactiveDataTable').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: false,
});
});



//Modal
function openModal() {
    $('#createNewViolation').modal('show');
}

function saveChanges() {
    $('#createNewViolation').modal('hide');
}

function openEditViolationModal(violationId) {
    $('#editViolationModal' + violationId).modal('show');
}

function openEditStudentModal(studentId) {
    $('#editStudentModal' + studentId).modal('show');
}

function openEditAccountsModal() {
    $('#editStudentModal').modal('show');
}

//Errors
$(document).ready(function () {
    $('#msgAlert').delay(2000).fadeOut(500);
});


//Fetch StudentName AJAX
function fetchStudentName() {
    var studentId = $('#student_id').val();

    $('#loading-spinner').show();

    $.ajax({
        type: 'GET',
        url: '/admin/report/' + studentId + '/get-student-name',
        success: function (data) {
            $('#loading-spinner').hide();

            $('#student_name').val(data);
        },
        error: function (error) {
            $('#loading-spinner').hide();

            console.log('Error:', error);
        }
    });
}



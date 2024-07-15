document.addEventListener('DOMContentLoaded', function() {
    const userList = document.getElementById('user-list');
    const addUserForm = document.getElementById('add-user-form');
    const updateUserForm = document.getElementById('update-user-form');
    const updateFormContainer = document.getElementById('update-form');

    // Fetch and display users
    function fetchUsers() {
        fetch('http://localhost/Jobapi/newapi/index.php')
            .then(response => response.json())
            .then(data => {
                userList.innerHTML = '';
                data.forEach(user => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <div>
                            <strong>${user.name}</strong>
                            <span>Age: ${user.age}</span>
                            <span>Email: ${user.email}</span>
                        </div>
                        <div>
                            <button class="update" data-id="${user.id}" data-name="${user.name}" data-age="${user.age}" data-email="${user.email}">Update</button>
                            <button class="delete" data-id="${user.id}">Delete</button>
                        </div>
                    `;
                    userList.appendChild(li);
                });
            });
    }

    // Add a new user
    addUserForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(addUserForm);
        const user = {
            name: formData.get('name'),
            age: formData.get('age'),
            email: formData.get('email')
        };

        fetch('http://localhost/Jobapi/newapi/index.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        })
        .then(response => response.json())
        .then(data => {
            fetchUsers();
            addUserForm.reset();
        });
    });

    // Populate update form
    userList.addEventListener('click', function(event) {
        if (event.target.classList.contains('update')) {
            const userId = event.target.getAttribute('data-id');
            const userName = event.target.getAttribute('data-name');
            const userAge = event.target.getAttribute('data-age');
            const userEmail = event.target.getAttribute('data-email');

            document.getElementById('update-id').value = userId;
            document.getElementById('update-name').value = userName;
            document.getElementById('update-age').value = userAge;
            document.getElementById('update-email').value = userEmail;

            updateFormContainer.style.display = 'block';
        }
    });

    // Update a user
    updateUserForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(updateUserForm);
        const userId = formData.get('id');
        const user = {
            name: formData.get('name'),
            age: formData.get('age'),
            email: formData.get('email')
        };

        fetch(`http://localhost/Jobapi/newapi/index.php/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        })
        .then(response => response.json())
        .then(data => {
            fetchUsers();
            updateUserForm.reset();
            updateFormContainer.style.display = 'none';
        });
    });

    // Delete a user
    userList.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete')) {
            const userId = event.target.getAttribute('data-id');
            fetch(`http://localhost/Jobapi/newapi/index.php/${userId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                fetchUsers();
            });
        }
    });

    // Initial fetch
    fetchUsers();
});

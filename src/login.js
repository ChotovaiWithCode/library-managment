// //access all id

// const admin = document.getElementById('Admin');
// const users = document.getElementById('Users');
// const signinTab = document.getElementById('signin-tab');
// const signupTab = document.getElementById('signup-tab');
// const signinForm = document.getElementById('signin-form');
// const signupForm = document.getElementById('signup-form');
// const gotoSignup = document.getElementById('goto-signup');
// const gotoSignin = document.getElementById('goto-signin');
// const roleField = document.getElementById('user-role');

// //function for activition

// //active signin and signup

// function activateTab(tab) {
//     if (tab === 'signin') {
//         signinTab.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         signupTab.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         signupTab.classList.add('text-gray-400');
//         signinForm.classList.remove('hidden');
//         signupForm.classList.add('hidden');
//     } else {
//         signupTab.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         signinTab.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         signinTab.classList.add('text-gray-400');
//         signupForm.classList.remove('hidden');
//         signinForm.classList.add('hidden');
//     }
// }

// //active admin and users

// function activateRole(role) {
//     if (role === 'admin') {
//         admin.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         users.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         users.classList.add('text-gray-400');
       
//     } else {
//         users.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         admin.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
//         admin.classList.add('text-gray-400');
       
//     }
//     roleField.value = role;
  



// }

// // addeventlistener
// signinTab.addEventListener('click', () => activateTab('signin'));
// signupTab.addEventListener('click', () => activateTab('signup'));
// gotoSignup.addEventListener('click', (e) => { e.preventDefault(); activateTab('signup'); });
// gotoSignin.addEventListener('click', (e) => { e.preventDefault(); activateTab('signin'); });

// admin.addEventListener('click', () => activateRole('admin'));
// users.addEventListener('click', () => activateRole('user'));



    // Access elements
    const adminBtn = document.getElementById('Admin');
    const usersBtn = document.getElementById('Users');
    const signinTab = document.getElementById('signin-tab');
    const signupTab = document.getElementById('signup-tab');
    const signinForm = document.getElementById('signin-form');
    const signupForm = document.getElementById('signup-form');
    const gotoSignup = document.getElementById('goto-signup');
    const gotoSignin = document.getElementById('goto-signin');

    // Default role
    let currentRole = "user"; // default

    // --- TAB SWITCHING ---
    function activateTab(tab) {
        if (tab === 'signin') {
            signinTab.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            signinTab.classList.remove('text-gray-400');
            signupTab.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            signupTab.classList.add('text-gray-400');

            signinForm.classList.remove('hidden');
            signupForm.classList.add('hidden');
        } else {
            signupTab.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            signupTab.classList.remove('text-gray-400');
            signinTab.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            signinTab.classList.add('text-gray-400');

            signupForm.classList.remove('hidden');
            signinForm.classList.add('hidden');
        }
    }

    // --- ROLE SWITCHING ---
    function setRole(role) {
        currentRole = role;
        // Update all hidden role inputs
        document.querySelectorAll('input[name="role"]').forEach(el => {
            el.value = role;
           
        });

        // Update button styles
        if (role === "admin") {
            adminBtn.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            adminBtn.classList.remove('text-gray-400');

            usersBtn.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            usersBtn.classList.add('text-gray-400');
        } else {
            usersBtn.classList.add('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            usersBtn.classList.remove('text-gray-400');

            adminBtn.classList.remove('font-bold', 'text-indigo-900', 'border-b-2', 'border-indigo-900');
            adminBtn.classList.add('text-gray-400');
        }
    }

    // Role button event listeners
    adminBtn.addEventListener('click', function (e) {
        e.preventDefault();
        setRole("admin");
    });

    usersBtn.addEventListener('click', function (e) {
        e.preventDefault();
        setRole("user");
    });

    // Tab button listeners
    signinTab.addEventListener('click', () => activateTab("signin"));
    signupTab.addEventListener('click', () => activateTab("signup"));
    gotoSignup.addEventListener('click', function (e) {
        e.preventDefault();
        activateTab("signup");
    });
    gotoSignin.addEventListener('click', function (e) {
        e.preventDefault();
        activateTab("signin");
    });

    // Default states
    activateTab("signin");
    setRole("user");

    

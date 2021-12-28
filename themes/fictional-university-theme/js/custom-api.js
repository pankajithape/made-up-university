var quickAddBtn = document.getElementById('quick-add-button');

if (quickAddBtn) {
    quickAddBtn.addEventListener('click', function() {
        var title = document.querySelector('.admin-quick-add [name="title"]').value;
        var content = document.querySelector('.admin-quick-add [name="content"]').value;

        // alert('Title:' + title);
        // alert('Content:' + content);
        
        var ourPostData = {
            "title": title,
            "content": content,
            "status": 'publish'
        }

        var responseDiv = document.getElementById('response')

        var createPost = new XMLHttpRequest();
        createPost.open('POST', 'http://fictionaluniversitylocal.local/wp-json/wp/v2/posts');
        createPost.setRequestHeader('X-WP-Nonce', additionalData.nonce );
        createPost.setRequestHeader('Content-Type', 'application/json;charset:utf=8');
        createPost.send(JSON.stringify(ourPostData));
        createPost.onreadystatechange = function () {
            if (createPost.readyState == 4) {
                if (createPost.status == 201) {
                    responseDiv.innerHTML = '<h4 style="color:green">Submitted successfully!</h4>'
                } else {
                    responseDiv.innerHTML = '<h4 style="color:red">Try Again!</h4>'
                }
            }
        }

    });
}
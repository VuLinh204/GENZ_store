// Xử lí click vào items trong sidebar
document.addEventListener("DOMContentLoaded", function () {
    var menuItems = document.querySelectorAll(".sidebar__menu-item");

    menuItems.forEach(function (item) {
        item.addEventListener("click", function () {
            var subMenu = this.querySelector(".sub__menu");
            var iconUp = this.querySelector(".sidebar__icon-up");
            var iconDown = this.querySelector(".sidebar__icon-down");

            this.classList.toggle("open");
            if (subMenu.style.display === "block") {
                subMenu.style.display = "none";
                iconUp.style.display = "none";
                iconDown.style.display = "inline-block";
            } else {
                subMenu.style.display = "block";
                iconUp.style.display = "inline-block";
                iconDown.style.display = "none";
            }
        });
    });
});

//Menu bar
document.addEventListener("DOMContentLoaded", function () {
    var menuBarIn = document.getElementById("menu__bar-in");
    var menuBarOut = document.getElementById("menu__bar-out");
    var sidebar = document.querySelector(".sidebar");
    var sidebarModal = document.getElementById("sidebarModal");
    var logoOut = document.getElementById("header__logo-out");

    if (menuBarIn && menuBarOut && sidebar && sidebarModal && logoOut) {
        menuBarOut.addEventListener("click", function (event) {
            event.stopPropagation();
            if (sidebar.classList.contains("hide")) {
                sidebar.classList.remove("hide");
                sidebarModal.classList.remove("hide");
                logoOut.classList.add("opacity-0");
            }
        });

        menuBarIn.addEventListener("click", function (event) {
            event.stopPropagation();
            if (!sidebar.classList.contains("hide")) {
                sidebar.classList.add("hide");
                sidebarModal.classList.add("hide");
                logoOut.classList.remove("opacity-0");
            }
        });

        sidebarModal.addEventListener("click", function (event) {
            event.stopPropagation();
            if (!sidebar.classList.contains("hide")) {
                sidebar.classList.add("hide");
                sidebarModal.classList.add("hide");
                logoOut.classList.remove("opacity-0");
            }
        });

        sidebar.addEventListener("click", function (event) {
            event.stopPropagation();
        });

        document.addEventListener("click", function () {
            if (!sidebar.classList.contains("hide")) {
                sidebar.classList.add("hide");
                sidebarModal.classList.add("hide");
            }
        });
    }
});

//detail Pagination
$(document).ready(function () {
    $(".related-products-slider").slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        prevArrow: '<button class="slick-prev"><</button>',
        nextArrow: '<button class="slick-next">></button>',
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });
});

// close in sign in sign up

function closeAlert() {
    var alert = document.querySelector(".alert");
    alert.style.display = "none";
}

// banner
document.addEventListener("DOMContentLoaded", function () {
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    let carouselItems = $$(".full-home-banners__main-item");
    let carouselIndicators = $$(".full-home-banners__main-dot");
    let carouselBtnLeft = $(".carosel-btn-left");
    let carouselBtnRight = $(".carosel-btn-right");
    let i = 0,
        lengthCarousel = carouselItems.length;

    function removeActiveCarousel() {
        const activeItem = $(".full-home-banners__main-item.active");
        const activeDot = $(".full-home-banners__main-dot.active");
        if (activeItem) {
            activeItem.classList.remove("active");
        }
        if (activeDot) {
            activeDot.classList.remove("active");
        }
    }

    function addActiveCarousel(i) {
        carouselItems[i].classList.add("active");
        carouselIndicators[i].classList.add("active");
    }

    let arrIndicators = Array.from(carouselIndicators);
    arrIndicators.forEach((indicator, index) => {
        const carouselItem = carouselItems[index];
        indicator.onclick = function () {
            i = index;
            removeActiveCarousel();
            carouselItem.classList.add("active");
            this.classList.add("active");
        };
    });

    carouselBtnLeft.onclick = function () {
        i--;
        if (i < 0) {
            i = lengthCarousel - 1;
        }
        removeActiveCarousel();
        addActiveCarousel(i);
    };

    carouselBtnRight.onclick = function () {
        i++;
        if (i >= lengthCarousel) {
            i = 0;
        }
        removeActiveCarousel();
        addActiveCarousel(i);
    };

    setInterval(() => {
        if (i === lengthCarousel - 1) {
            i -= lengthCarousel;
        }
        i++;
        removeActiveCarousel();
        addActiveCarousel(i);
    }, 5000);
});

//tăng giảm số lượng sản phẩm trong detail
function incrementQuantity() {
    var quantityInput = document.getElementById("product-quantity");
    var currentQuantity = parseInt(quantityInput.value, 10);
    quantityInput.value = currentQuantity + 1;
}

function decrementQuantity() {
    var quantityInput = document.getElementById("product-quantity");
    var currentQuantity = parseInt(quantityInput.value, 10);
    if (currentQuantity > 1) {
        quantityInput.value = currentQuantity - 1;
    }
}
// size color
document.addEventListener("DOMContentLoaded", function () {
    const sizeButtons = document.querySelectorAll(".size-btn");
    const colorButtons = document.querySelectorAll(".color-btn");

    sizeButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            sizeButtons.forEach((b) => b.classList.remove("active")); // Xóa active khỏi tất cả các nút kích cỡ
            this.classList.add("active"); // Thêm active vào nút được nhấn
        });
    });

    colorButtons.forEach((btn) => {
        btn.addEventListener("click", function () {
            colorButtons.forEach((b) => b.classList.remove("active")); // Xóa active khỏi tất cả các nút màu sắc
            this.classList.add("active"); // Thêm active vào nút được nhấn
        });
    });
});

// thêm size and color vào cart
document.addEventListener("DOMContentLoaded", function () {
    const sizeButtons = document.querySelectorAll(".size-btn");
    const colorButtons = document.querySelectorAll(".color-btn");
    const sizeInput = document.getElementById("selected_size");
    const colorInput = document.getElementById("selected_color");

    sizeButtons.forEach((button) => {
        button.addEventListener("click", function () {
            sizeButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
            sizeInput.value = this.getAttribute("data-size");
        });
    });

    colorButtons.forEach((button) => {
        button.addEventListener("click", function () {
            colorButtons.forEach((btn) => btn.classList.remove("active"));
            this.classList.add("active");
            colorInput.value = this.getAttribute("data-color");
        });
    });
});
//thông báo khi chưa chọn size color
function addToCart() {
    var selectedSize = document.getElementById("selected_size").value;
    var selectedColor = document.getElementById("selected_color").value;

    if (!selectedSize || !selectedColor) {
        alert("Vui lòng chọn size và color trước khi thêm vào giỏ hàng.");
        return false; // Ngăn chặn gửi yêu cầu nếu chưa chọn size hoặc color
    }
}

// Hàm để điều hướng đến URL mới và lưu trạng thái active
function navigateTo(url) {
    setActiveSort(url);
    window.location.href = url;
}

// Hàm để đặt trạng thái active vào localStorage
function setActiveSort(sortUrl) {
    localStorage.setItem("activeSort", sortUrl);
}

// Xử lý active cho các nút sắp xếp
document.addEventListener("DOMContentLoaded", function () {
    var sortLinks = document.querySelectorAll(".select-input__link");
    var categoryLinks = document.querySelectorAll(".manager-item__link");
    var sortButtons = document.querySelectorAll(".home-filter__btn");
    var activeSort = localStorage.getItem("activeSort");

    // Kiểm tra và áp dụng trạng thái active cho nút sắp xếp
    if (activeSort) {
        var activeBtn = document.querySelector(
            ".home-filter__btn[onclick=\"navigateTo('" + activeSort + "')\"]"
        );
        if (activeBtn) {
            activeBtn.classList.add("active");
        }
    } else {
        // Nếu không có trạng thái active trong localStorage, mặc định chọn "Mới nhất"
        var newestBtn = document.querySelector(
            ".home-filter__btn[onclick=\"navigateTo('{{ $newestUrl }}')\"]"
        );
        if (newestBtn) {
            newestBtn.classList.add("active");
        }
    }

    // Thêm sự kiện click cho các nút sắp xếp
    sortButtons.forEach(function (btn) {
        btn.addEventListener("click", function () {
            // Xóa trạng thái active khỏi tất cả các nút sắp xếp
            sortButtons.forEach(function (item) {
                item.classList.remove("active");
            });

            sortLinks.forEach(function (item) {
                item.classList.remove("active");
            });

            // Thêm trạng thái active cho nút được click
            this.classList.add("active");

            // Lưu trạng thái active vào localStorage
            var sortUrl = this.getAttribute("onclick").match(
                /navigateTo\('([^']+)'\)/
            )[1];
            localStorage.setItem("activeSort", sortUrl);
        });
    });

    // Loại bỏ trạng thái active của các nút sắp xếp khi các liên kết sắp xếp theo giá được nhấp
    sortLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            sortButtons.forEach(function (item) {
                item.classList.remove("active");
            });
            localStorage.removeItem("activeSort");
        });
    });

    // Xử lý active cho các thẻ sắp xếp theo giá
    sortLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            // Xóa class "active" từ tất cả các thẻ sắp xếp
            sortLinks.forEach(function (item) {
                item.classList.remove("active");
            });

            // Thêm class "active" cho thẻ sắp xếp được chọn
            this.classList.add("active");

            // Lưu trạng thái active vào local storage
            localStorage.setItem("selectedSort", this.getAttribute("href"));
        });
    });

    var selectedSort = localStorage.getItem("selectedSort");
    if (selectedSort) {
        var activeLinkSort = document.querySelector(
            '.select-input__link[href="' + selectedSort + '"]'
        );
        if (activeLinkSort) {
            activeLinkSort.classList.add("active");
        }
    }

    // Xử lý active cho các thẻ danh mục
    categoryLinks.forEach(function (link) {
        link.addEventListener("click", function () {
            // Xóa class "active" từ tất cả các thẻ danh mục
            categoryLinks.forEach(function (item) {
                item.classList.remove("active");
            });

            // Thêm class "active" cho thẻ danh mục được chọn
            this.classList.add("active");

            // Lưu trạng thái active vào local storage
            localStorage.setItem("selectedCategory", this.getAttribute("href"));
        });
    });

    var selectedCategory = localStorage.getItem("selectedCategory");
    if (selectedCategory) {
        var activeLink = document.querySelector(
            '.manager-item__link[href="' + selectedCategory + '"]'
        );
        if (activeLink) {
            activeLink.classList.add("active");
        }
    }
});

// Comment
// Xử lý khi click nút chỉnh sửa bình luận
function editComment(commentId, commentBody) {
    var commentTextElement = document.getElementById('comment-text-' + commentId);
    
    // Tạo một textarea element để chỉnh sửa nội dung bình luận
    var inputElement = document.createElement('textarea');
    inputElement.className = 'form-control ml-1 shadow-none textarea';
    inputElement.id = 'comment-edit-' + commentId;
    inputElement.value = commentBody;

    // Tạo một button để lưu thay đổi
    var saveButton = document.createElement('button');
    saveButton.className = 'btn btn-primary btn-sm';
    saveButton.textContent = 'Lưu';
    saveButton.onclick = function () {
        saveEditedComment(commentId);
    };

    // Tạo một button để hủy thao tác chỉnh sửa
    var cancelButton = document.createElement('button');
    cancelButton.className = 'btn btn-outline-primary btn-sm ml-1 shadow-none';
    cancelButton.textContent = 'Hủy';
    cancelButton.onclick = function () {
        cancelEdit(commentId, commentBody);
    };

    // Thay thế nội dung bình luận bằng form chỉnh sửa
    commentTextElement.innerHTML = '';
    commentTextElement.appendChild(inputElement);
    commentTextElement.appendChild(saveButton);
    commentTextElement.appendChild(cancelButton);
}
window.cancelEdit = function(commentId, commentBody) {
    var commentTextElement = document.getElementById('comment-text-' + commentId);
    commentTextElement.innerHTML = commentBody;
};
// Xử lý khi click nút lưu sau khi chỉnh sửa bình luận
function saveEditedComment(commentId) {
    var editedComment = document.getElementById('comment-edit-' + commentId).value;

    // Gửi yêu cầu cập nhật bình luận qua Ajax
    fetch(`/comments/${commentId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ body: editedComment })
    }).then(response => response.json()).then(data => {
        // Hiển thị thông báo thành công hoặc thất bại
        if (data.success) {
            document.getElementById('comment-text-' + commentId).innerHTML = editedComment;
        } else {
            alert(data.error || 'Có lỗi xảy ra.');
        }
    });
}

// Xử lý khi click nút xóa bình luận
function deleteComment(commentId) {
    if (confirm('Bạn có chắc chắn muốn xóa bình luận này không?')) {
        document.getElementById('deleteForm-' + commentId).submit();
    }
}

function cancelComment() {
    document.getElementById("commentForm").reset();
}
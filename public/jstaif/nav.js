// const hamburger = document.querySelector(".hamburger");
// const nav_ul = document.querySelector(".nav-links");

// hamburger.addEventListener('click', mobileMenu);

// function mobileMenu() {
//       hamburger.classList.toggle('active');
//       nav_ul.classList.toggle('active');
// }

// const navLink = document.querySelectorAll(".nav-link");

// navLink.forEach(n => n.addEventListener('click', closeMenu));

// function closeMenu() {
//       hamburger.classList.remove("active");
//       nav_ul.classList.remove("active");
// }


exports.login = async (req, res) => {
      try {
            const user = await User.findOne({ email: req.body.email });
            if (!user) {
                  res.status(StatusCodes.NOT_FOUND).json({
                        msg: "No user found",
                  });
            }

            const isValid = await bcrypt.compare(req.body.password, user.password);
            if (isValid) {
                  res.status(StatusCodes.ACCEPTED).json({
                        msg: "logged in successfully",
                        user,
                  });
            } else {
                  res.status(StatusCodes.INTERNAL_SERVER_ERROR).json({
                        msg: "Invalid login info",
                  })
            };

      } catch (error) {
            res.status(StatusCodes.INTERNAL_SERVER_ERROR).json({
                  msg: error.message,
            });
      }
};

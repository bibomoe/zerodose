<div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo" srcset="" style="width: 60px; height: auto;" > 
                        </div>
                        <div class="logo">
                            <img src="<?= base_url('assets/kemenkes2.png'); ?>" alt="Logo" srcset="" style="width: 30px; height: auto;" > 
                        </div>
                        <!-- <div class="language-toggle" id="language-toggle">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Flag_of_Indonesia.svg/2560px-Flag_of_Indonesia.svg.png" alt="Indonesian Flag" id="lang-id">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/2560px-Flag_of_the_United_States.svg.png" alt="English Flag" id="lang-en" style="display: none;">
                        </div> -->
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg> -->
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg> -->
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        
                        <!-- <li
                            class="sidebar-item">
                            <a href="<?= base_url('home'); ?>" class='sidebar-link'>
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>Current ZD Cases</span>
                            </a>
                            </li>

                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/restored'); ?>" class='sidebar-link'>
                                    <i class="bi bi-shield-fill-check"></i>
                                    <span>Restored ZD Children</span>
                                </a>
                            </li>

                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/lost'); ?>" class='sidebar-link'>
                                    <i class="bi bi-person-dash-fill"></i>
                                    <span>Lost Children</span>
                                </a>
                            </li>
                            
                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/dpt1'); ?>" class='sidebar-link'>
                                    <i class="bi bi-tree-fill"></i>
                                    <span>DPT 1 in targeted areas</span>
                                </a>
                            </li>

                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/zd_tracking'); ?>" class='sidebar-link'>
                                    <i class="bi bi-building-fill"></i>
                                    <span>Percentage of Primary Health Facility to Conduct Immunization Service as Planned</span>
                                </a>
                            </li>
                            
                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/dpt_stock'); ?>" class='sidebar-link'>
                                    <i class="bi bi-hospital-fill"></i>
                                    <span>Number of DTP Stock Out at Health Facilities</span>
                                </a>
                            </li>

                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/private_health_facilities'); ?>" class='sidebar-link'>
                                    <i class="bi bi-house-heart-fill"></i>
                                    <span>Number of Private Health Facilities in Targeted Areas​</span>
                                </a>
                            </li>

                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/district'); ?>" class='sidebar-link'>
                                    <i class="bi bi-file-earmark-fill"></i>
                                    <span>District Program and Policy</span>
                                </a>
                            </li>

                            <li
                                class="sidebar-item">
                                <a href="<?= base_url('home/grant_implementation'); ?>" class='sidebar-link'>
                                    <i class="bi bi-currency-dollar"></i>
                                    <span>Grants Implementation and Budget Disbursement</span>
                                </a>
                            </li> -->

                        
                        <?php
                            $user_category = $this->session->userdata('user_category');
                            if ($user_category != 7 && $user_category != 8) { 
                        ?>
                        <li
                            class="sidebar-item">
                            <a href="<?= base_url('home'); ?>" class='sidebar-link'>
                                <i class="bi bi-house-heart-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        

                        <!-- Long-term Health Outcomes -->
                        <li
                            class="sidebar-item  ">
                            <a href="<?= base_url('home/restored'); ?>" class='sidebar-link'>
                                <i class="bi bi-shield-fill-check"></i>
                                <span>Long-term Health Outcomes</span>
                            </a>
                            
                            <!-- <ul class="submenu ">
                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/restored'); ?>" class='sidebar-link'>
                                        Restored ZD Children
                                    </a>
                                </li>
                            </ul> -->
                            
                        </li>

                        <!-- Intermediate Health Outcomes -->
                        <li
                            class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>Intermediate Health Outcomes</span>
                            </a>
                            
                            <ul class="submenu ">
                                <!-- <li class="submenu-item  ">
                                    <a href="<?= base_url('home/zd_cases'); ?>" class='sidebar-link'>
                                        Current ZD Cases
                                    </a>
                                </li> -->

                                <!-- <li class="submenu-item  ">
                                    <a href="<?= base_url('home/lost'); ?>" class='sidebar-link'>
                                        Lost Children
                                    </a>
                                </li> -->
                                
                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/dpt1'); ?>" class='sidebar-link'>
                                        DPT 1 in targeted areas
                                    </a>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/dpt_stock'); ?>" class='sidebar-link'>
                                        Number of DTP Stock Out at Health Facilities
                                    </a>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/zd_tracking'); ?>" class='sidebar-link'>
                                        Percentage of Primary Health Facility to Conduct Immunization Service as Planned
                                    </a>
                                </li>
                                

                                <!-- <li class="submenu-item  ">
                                    <a href="<?= base_url('home/private_health_facilities'); ?>" class='sidebar-link'>
                                        Number of Private Health Facilities in Targeted Areas​
                                    </a>
                                </li> -->

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/district'); ?>" class='sidebar-link'>
                                        District Program
                                    </a>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/policy'); ?>" class='sidebar-link'>
                                        District Policy and Financing
                                    </a>
                                </li>
                                
                            </ul>
                            
                        </li>

                        

                        <!-- Immunization Policy & Financing Outcomes -->
                        <!-- <li
                            class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-file-earmark-fill"></i>
                                <span>Immunization Policy & Financing Outcomes</span>
                            </a>
                            
                            <ul class="submenu ">
                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/policy'); ?>" class='sidebar-link'>
                                        District Policy and Financing
                                    </a>
                                </li>
                                
                            </ul>
                            
                        </li> -->

                        <?php
                            $user_category = $this->session->userdata('user_category');
                            if ($user_category != 7 && $user_category != 8) { 
                        ?>
                        <!-- Grants Implementation and Budget Disbursement Menu -->
                        <li
                            class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-currency-dollar"></i>
                                <span>Grant Implementation & Budget Disbursement Outcomes</span>
                            </a>
                            
                            <ul class="submenu ">
                                <li class="submenu-item  ">
                                    <a href="<?= base_url('home/grant_implementation'); ?>" class='sidebar-link'>
                                        Activity and Budget Realization
                                    </a>
                                </li>
                                <!-- <li class="submenu-item  ">
                                    <a href="<?= base_url('home/activity_tracker'); ?>" class='sidebar-link'>
                                        Activity
                                    </a>
                                </li> -->
                            </ul>
                            
                        </li>
                        <?php
                            }
                        ?>
                        <?php
                            $user_category = $this->session->userdata('user_category');
                            if ($user_category != 7 && $user_category != 8) { 
                        ?>

                        <!-- Input Form Menu -->
                        <li
                            class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-pen-fill"></i>
                                <span>Entry Form</span>
                            </a>
                            
                            <ul class="submenu ">
                                <!-- <li class="submenu-item has-sub">
                                    <a href="#" class="submenu-link">Entry Form</a>
                                
                                    <ul class="submenu submenu-level-2 ">
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input'); ?>" class="submenu-link">Current ZD Cases</a>
                                            
                                        </li>
                                        
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/lost'); ?>" class="submenu-link">Lost Children</a>
                                            
                                        </li>
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/dpt1'); ?>" class="submenu-link">DPT 1 in targeted areas</a>
                                            
                                        </li>
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/zd_tracking'); ?>" class="submenu-link">Percentage of Primary Health Facility to Conduct Immunization Service as Planned</a>
                                            
                                        </li>
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/dpt_stock'); ?>" class="submenu-link">Number of DTP Stock Out at Health Facilities</a>
                                            
                                        </li>
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/private_health_facilities'); ?>" class="submenu-link">Number of Private Health Facilities in Targeted Areas</a>
                                            
                                        </li>
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/district'); ?>" class="submenu-link">District Program</a>
                                        </li>
                                        
                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/restored'); ?>" class="submenu-link">Restored ZD Children</a>
                                        </li>

                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/policy'); ?>" class="submenu-link">District Policy and Financing</a>
                                        </li>

                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/grant_implementation'); ?>" class="submenu-link">Grants Implementation and Budget Disbursement</a>
                                            
                                        </li>

                                        <li class="submenu-item  ">
                                            <a href="<?= base_url('input/activity_tracker'); ?>" class="submenu-link">Activity Tracker</a>
                                            
                                        </li>
                                    </ul>
                                </li> -->
                                <li class="submenu-item  ">
                                    <a href="<?= base_url('input/activity_tracker'); ?>" class="submenu-link">Activity</a>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('input/target'); ?>" class="submenu-link">Target</a>
                                </li>

                                <?php
                                    $user_category = $this->session->userdata('user_category');
                                    if ($user_category == 2 || $user_category == 9) { 
                                ?>

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('input/excel'); ?>" class='sidebar-link'>
                                        Excel
                                    </a>
                                </li>

                                <li class="submenu-item  ">
                                    <a href="<?= base_url('input/manual'); ?>" class='sidebar-link'>
                                        Manual
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                                
                            </ul>
                            

                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

<div id="main" class='layout-navbar navbar-fixed'>
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600"><?= isset($session_name) ? $session_name : ''; ?></h6>
                                            <p class="mb-0 text-sm text-gray-600"><?= isset($session_user_category_name) ? $session_user_category_name : ''; ?></p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="<?= base_url('assets/compiled/jpg/1.jpg'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                                    <!-- <li>
                                        <h6 class="dropdown-header">Hello, John!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                            Settings</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-wallet me-2"></i>
                                            Wallet</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li> -->
                                    <li><a class="dropdown-item" href="<?= base_url('auth/logout'); ?>"><i
                                                class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
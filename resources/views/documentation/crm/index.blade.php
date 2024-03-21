<!doctype html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>PeoplePro - CRM Addon</title>
    <meta name="description" content="Attendance Device Addon for PeoplePro- HR Management System" />
    <meta name="author" content="LionCoders">
    <meta name="copyright" content="LionCoders">

    <!-- Google fonts - Roboto -->
    <link rel="icon" type="image/png" href="{{asset('docs/crm/assets/images/logo.png')}}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700">
    <link rel="stylesheet" href="{{ asset('docs/attendance_device_addon/assets/css/documenter_style.css')}}" media="all">
    <link rel="stylesheet" href="{{ asset('docs/attendance_device_addon/assets/css/jquery.mCustomScrollbar.css')}}" media="all">

    <script src="{{ asset('docs/attendance_device_addon/assets/js/jquery.js')}}"></script>
    <script src="{{ asset('docs/attendance_device_addon/assets/js/jquery.mCustomScrollbar.js')}}"></script>
    <script src="{{ asset('docs/attendance_device_addon/assets/js/typeAhead.js')}}"></script>
    <script src="{{ asset('docs/attendance_device_addon/assets/js/script.js')}}"></script>
</head>

<body>
<div id="documenter_sidebar">
    <img src="{{ asset('docs/crm/assets/images/logo.png')}}" style="border: none;margin: 0 10px -10px;width: 200px">
    <ul id="documenter_nav">
        <li><a class="current" href="#documenter_cover">Start</a></li>
        <li><a href="#requirement" title="REQUIREMENTS">Requirements</a></li>
        <li><a href="#install" title="INSTALL">Install</a></li>
        <li><a href="#leads" title="Leads">Leads</a></li>
        <li><a href="#leadsContact" title="Leads">Leads | Contact</a></li>
        <li><a href="#leadsInfo" title="Leads | Lead Info">Leads | Lead Info</a></li>
        <li><a href="#leadsTask" title="Leads | Task">Leads | Task</a></li>
        <li><a href="#leadsEstimate" title="Leads | Estimate">Leads | Estimate</a></li>
        <li><a href="#leadsProposal" title="Leads | Proposal">Leads | Proposal</a></li>
        <li><a href="#leadsContracts" title="Leads | Contracts">Leads | Contracts</a></li>
        <li><a href="#leadsNotes" title="Leads | Notes">Leads | Notes</a></li>
        <li><a href="#subscription" title="Subscription">Subscription</a></li>
        <li><a href="#itemCategory" title="Item Category">Item Category</a></li>
        <li><a href="#item" title="Item">Item</a></li>
        <li><a href="#invoices" title="Invoices">Invoices</a></li>
        <li><a href="#store" title="Store">Store</a></li>
        <li><a href="#orderList" title="Order List">Order List</a></li>
        <li><a href="#payment" title="Payment">Payment</a></li>
        <li><a href="#contracts" title="Contracts">Contracts</a></li>
        <li><a href="#prospectsProposals" title="Prospects | Proposals">Proposals </a></li>
        <li><a href="#prospectsEstimate" title="Prospects | Estimate">Estimate </a></li>
        <li><a href="#prospectsEstimateRequest" title="Prospects | Estimate Request Form">Estimate Request Form</a></li>
        <li><a href="#support" title="SUPPORT">Support</a></li>
    </ul>
</div>
<div id="documenter_content">


    <div id="the-basics">
        <input class="typeahead form-control" type="text" placeholder="Search">
    </div>


    <section id="documenter_cover">
        <h1>PeoplePro - CRM Addon
        </h1>
        <div id="documenter_buttons">
        </div>
        <hr>
        <ul>
            <li>by : LionCoders</li>
            <li>Support : <a href="mailto:support@lion-coders.com">support@lion-coders.com</a></li>
        </ul>
        <p>PeoplePro - CRM Addon extends our popular HR software PeoplePro to manage the customer relationship.
        </p>
    </section>

    <section id="requirement">
        <div class="page-header">
            <h3>REQUIREMENT</h3>
            <hr class="notop">
        </div>
        <p>
            To integrate the addon, you need to have existing installation of our HR software PeoplePro.
        </p>
    </section>

    <section id="install">
        <div class="page-header">
            <h3>INSTALL</h3>
            <hr class="notop">
        </div>
        <p>
            Now follow the installation process below.
        </p>


        <h2><strong>Step 1</strong></h2>
        <ul>
            <li>
                Please go Addons and click on Install button.
            </li>
            <img alt="" src="{{ asset('docs/crm/assets/images/step1.png')}}">
        </ul>
        <h2><strong>Step 2</strong></h2>
        <ul>
            <li>
                Please read the license arrangement before proceeding.
            </li>

            <li> You need to accept and continue for going to
                the next step.
            </li>
            <img alt="" src="{{ asset('docs/crm/assets/images/step2.png')}}">
        </ul>
        <h2><strong>Step 3</strong></h2>
        <ul>
            <li>
                The system will automatically check for the server requirements. If all the requirements are
                fulfilled,
                You can proceed for further action.
            </li>
            <img alt="" src="{{ asset('docs/crm/assets/images/step3.png')}}">
        </ul>
        <h2><strong>Step 4</strong></h2>
        <ul>
            <li>
                You have to fill up the form with correct information.
            </li>
            <li>Please input the purchase code.
            </li>
            <li>
                Click on submit.
            </li>
            The system wil automatically import the database. This is a
            batch process,please wait patiently while the action is processing.
            </li>
            <img alt="" src="{{ asset('docs/crm/assets/images/step4.png')}}">
            <img alt="" src="{{ asset('docs/crm/assets/images/step5.png')}}">
        </ul>
        <h2><strong>Step 5</strong></h2>
        <ul>
            <li>
                Congratulations! You have successfully installed PeoplePro CRM.<br>
                <strong>Note :</strong> your project folder contains 'install' folder, then please delete
                the folder.
            </li>
            <img alt="" src="{{ asset('docs/crm/assets/images/step6.png')}}">
        </ul>

        <h2><strong>Help with installation</strong></h2>
        <p>
            We can help you install on any cpanel based hosting for as little as $15. You can send the money via paypal to tarik_17@yahoo.co.uk. Contact us at support@lion-coders.com with you hosting details and payment proof and we'll take care of the rest.
        </p>
        {{-- <p>
            <b>Please note -</b> If you are installing on localhost, we'll charge $50 for anydesk/teamviewer support(installation).
        </p> --}}

        <br><br>

        <h2><strong>Error</strong></h2>
        <ul>
            <li>
                If you face a "Fatal error: Maximum execution time of ** seconds exceeded",
                Do not worry, the software is installed properly.<br>
                <strong>Note :</strong> After installtion, please go to asset folder from root directory and then check a 'install' folder still exits or not, if exists then delete it.
            </li>
        </ul>

        <p>After successful installation you can login with <br>
            username:<strong>admin</strong><br>
            password:<strong>admin</strong></p>
        <br>
    </section>

    <section id="leads">
        <div class="page-header">
            <h3>Leads</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> <br>
            There is a Lead Section option. You can add/edit/delete lead record for an employee.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-1.png')}}">
    </section>

    <section id="leadsContact">
        <div class="page-header">
            <h3>Leads | Contact</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Contact</strong> <br>
            There is a Contact in Lead Section. You can add/edit/delete Contact records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-2.png')}}">
    </section>

    <section id="leadsInfo">
        <div class="page-header">
            <h3>Leads | Lead Info</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Lead Info</strong> <br>
            There is a Lead Info Section. You can only visible the records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-3.png')}}">
    </section>

    <section id="leadsTask">
        <div class="page-header">
            <h3>Leads | Task</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Task</strong> <br>
            There is a Task in Lead Section.You can add/edit/delete the Task records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-4.png')}}">
    </section>

    <section id="leadsEstimate">
        <div class="page-header">
            <h3>Leads | Estimate</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Estimate</strong> <br>
            There is a Estimate in Lead Section.You can add/edit/delete the Estimate records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-5.png')}}">
    </section>

    <section id="leadsProposal">
        <div class="page-header">
            <h3>Leads | Proposal</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Proposal</strong> <br>
            There is a Proposal in Lead Section.You can add/edit/delete the Proposal records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-6.png')}}">
    </section>

    <section id="leadsContracts">
        <div class="page-header">
            <h3>Leads | Contracts</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Contracts</strong> <br>
            There is a Contracts in Lead Section.You can add/edit/delete the Contracts records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-7.png')}}">
    </section>

    <section id="leadsNotes">
        <div class="page-header">
            <h3>Leads | Notes</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Leads</strong> --> <strong>Notes</strong> <br>
            There is a Notes in Lead Section.You can add/edit/delete the Notes records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-8.png')}}">
    </section>

    <section id="subscription">
        <div class="page-header">
            <h3>Subscription</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Subscription</strong> <br>
            There is a Subscription Section.You can add/edit/delete the Subscription records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-9.png')}}">
    </section>

    <section id="itemCategory">
        <div class="page-header">
            <h3>Item Category</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Sales</strong> --> <strong>Item Category</strong> <br>
            There is a Item Category part in Sales section.You can add/edit/delete the Item Category  records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-10.png')}}">
    </section>


    <section id="item">
        <div class="page-header">
            <h3>Item</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Sales</strong> --> <strong>Item</strong> <br>
            There is a Item part in Sales section.You can add/edit/delete the Item records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-11.png')}}">
    </section>

    <section id="invoices">
        <div class="page-header">
            <h3>Invoices</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Sales</strong> --> <strong>Invoices</strong> <br>
            There is a Invoices part in Sales section.You can add/edit/delete the Invoices records.
        </p>
        <p><b># Datatable</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-12.png')}}">
        <p><b># Create Invoice</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-13.png')}}">
        <p><b># View Details Invoice</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-14.png')}}">
        <p><b># Edit Invoice</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-15.png')}}">
    </section>

    <section id="store">
        <div class="page-header">
            <h3>Store</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Sales</strong> --> <strong>Store</strong> <br>
            There is a Store part in Sales section.You can add to cart product.
        </p>
        <p><b># Items</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-16.png')}}">
        <p><b># Add to Cart</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-17.png')}}">
        <p><b># Checkout</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-18.png')}}">


    </section>

    <section id="orderList">
        <div class="page-header">
            <h3>Order List</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Sales</strong> --> <strong>Order List</strong> <br>
            There is a Order List in Sales section.You can only view the list and details.
        </p>
        <p><b># Datatable</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-19.png')}}">
        <p><b># Order Details</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-20.png')}}">
    </section>

    <section id="payment">
        <div class="page-header">
            <h3>Payment</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Sales</strong> --> <strong>Payment</strong> <br>
            There is a Payment List in Sales section.You can add/edit/delete the Payment records.
        </p>
        <p><b># Datatable</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-21.png')}}">
        <p><b># Add Payment</b></p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-22.png')}}">
    </section>


    <section id="contracts">
        <div class="page-header">
            <h3>Contracts</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Contracts</strong><br>
            There is a Contracts part.You can add/edit/delete the Contracts records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-23.png')}}">
        <p>
            <strong>Contracts</strong> -> <strong>Contracts Items</strong><br>
            There is a Contracts Items part in every Contract.You can add/edit/delete the Contract Items records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-24.png')}}">
    </section>


    <section id="prospectsProposals">
        <div class="page-header">
            <h3>Proposals</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Prospects</strong> --> <strong>Proposals</strong><br>
            There is a Proposals part in Prospects Section.You can add/edit/delete the Proposals records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-25.png')}}">
        <p>
            <strong>Prospects</strong> --> <strong>Proposals</strong> --> <strong>Proposals Items</strong><br>
            There is a Proposals Items part in every Proposals.You can add/edit/delete the  Proposals Items records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-26.png')}}">
    </section>

    <section id="prospectsEstimate">
        <div class="page-header">
            <h3>Estimate</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Prospects</strong> --> <strong>Estimate</strong><br>
            There is a Estimate part in Prospects Section.You can add/edit/delete the Estimate records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-27.png')}}">
        <p>
            <strong>Prospects</strong> --> <strong>Estimate</strong> --> <strong>Estimate Items</strong><br>
            There is a Estimate Items part in every Estimate.You can add/edit/delete the  Estimate Items records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-28.png')}}">
    </section>

    <section id="prospectsEstimateRequest">
        <div class="page-header">
            <h3>Estimate Request Form</h3>
            <hr class="notop">
        </div>
        <p>
            <strong>Prospects</strong> --> <strong>Estimate Request Form</strong><br>
            There is a Estimate Request Form part in Prospects Section.You can add/edit/delete the Estimate Request Form records.
        </p>
        <img alt="" src="{{ asset('docs/crm/assets/images/pic-29.png')}}">
    </section>


    <section id="support">
        <div class="page-header">
            <h3>SUPPORT</h3>
            <hr class="notop">
        </div>
        <p> We are happy to provide support for any issues within our software. We also provide customization service for as little as $15/hour. So if you have any features in mind or suugestions, please feel free to knock us at <a href="https://lion-coders.com/support">lion-coders.com/support</a>. Please note that we don't provide support though any other means (example- whatsapp, remote platform, comments etc). And if any client modify/add any code of our script and then face problem, we don't provide the support on that specific feature where he/she face problem. We only fix the bugs/issues if it's exists from previous. So, please refrain from commenting your queries on codecanyon or kocking us elsewhere.</p>
        <p>Also, in case of any errors/bugs/issues on your installation, please contact us with your hosting details (url, username, password), software admin access (url, username, password) and purchase code. If your support period has expired, please renew support on codecanyon before contacting us for support.</p>
        <p>Thank you and with best wishes - <a href="http://lion-coders.com">LionCoders</a></p>
    </section>

</div>
<script type="text/javascript">

    $("#documenter_sidebar").mCustomScrollbar({
        theme: "light",
        scrollInertia: 200
    });


    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function (i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var states = ['Start',
        'Requirements',
        'Install',
        'Software Update',
        'Log In',
        'Admin Dashboard',
        'Empty Database',
        'Datatable Options',
        'Location',
        'Company',
        'Department',
        'Designation',
        'Office Shift',
        'Account List',
        'Roles Access',
        'General Setting',
        'Mail Server',
        'Language Setting',
        'Variable Type',
        'Variable Method',
        'Employee List',
        'Import Employee',
        'User List',
        'Assign Role',
        'User Last Login',
        'Location',
        'Award',
        'Travel',
        'Transfer',
        'Resignation',
        'Complaint',
        'Warning',
        'Termination',
        'Announcement',
        'Company Policy',
        'Attendance',
        'Datewise Attendance',
        'Monthly Attendance',
        'Update Attendance',
        'Import Attendance',
        'Manage Holiday',
        'Manage Leave',
        'Payslip Report',
        'Attendance Report',
        'Training Report',
        'Project Report',
        'Task Report',
        'Employee Report',
        'Account Report',
        'Expense Report',
        'Deposit Report',
        'Transaction Report',
        'Job Post',
        'Job Candidate',
        'Job Interview',
        'CMS',
        'New Payment',
        'Payslip History',
        'HR Calendar',
        'Event',
        'Meeting',
        'Client',
        'Tax Type',
        'Project',
        'Task',
        'Invoice',
        'Support Ticket',
        'Account Balance',
        'Payee',
        'Payer',
        'Deposit',
        'Expense',
        'Transaction',
        'Transfer',
        'Asset Category',
        'Asset',
        'File Configuration',
        'File Manager',
        'Official Document',
        'Client Dashboard',
        'Client Project',
        'Client Task',
        'Client Invoice',
        'Client Invoice Paid',
        'Employee Dashboard',
        'Support',
        'General Error'
    ];

    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            source: substringMatcher(states)
        });

    $('.typeahead').bind('typeahead:select', function (ev, suggestion) {
        let a = suggestion.toLowerCase();
        a = a.replace(/\s+/g, "_");

        let site_url = window.location.href;

        site_url = site_url.split("#")[0];

        window.location.href = site_url + '#' + a;
    });


</script>
</body>

</html>

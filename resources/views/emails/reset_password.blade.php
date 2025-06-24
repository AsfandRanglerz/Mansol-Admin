@component('mail::message')
<div style="text-align: center; margin-bottom: 30px;">
    <img src="{{ asset('public/admin/assets/images/mansol-01.png') }}" alt="Mansol Logo"
        style="height: 100px; width: 275px; margin-bottom: 20px; object-fit:contain">
    <h1 style="font-size: 24px; font-weight: 600; margin: 0;">Reset Your Password</h1>
</div>

<p>Hello,</p>

<p>We received a request to reset the password associated with your <strong>Mansol</strong> account. To continue, please click the button below:</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 20px auto; text-align: center;">
    <tr>
        <td>
            <a href="{{ $detail['url'] }}" class="btn btn-primary" target="_blank" 
               style="
                   background-color: #d5363c;
                   color: #ffffff;
                   padding: 10px 20px;
                   text-decoration: none;
                   font-weight: bold;
                   border-radius: 4px;
                   display: inline-block;
                   border: 1px solid #d5363c;
               ">
                Reset Password
            </a>
        </td>
    </tr>
</table>


<p>If you did not request a password reset, you can safely ignore this email. Your account will remain secure and no changes will be made.</p>

---

<br>

Kind regards,  
<strong>The Mansol Team</strong>

@endcomponent

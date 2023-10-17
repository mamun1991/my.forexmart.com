<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = 'ইমেল বৈধতা পদ্ধতিটি অবশ্যই একটি অ্যারে পাস করতে হবে।';
$lang['email_invalid_address'] = 'অকার্যকর ইমেইল ঠিকানা: %s';
$lang['email_attachment_missing'] = 'নিম্নলিখিত ইমেল সংযুক্তি সনাক্ত করা যাচ্ছে না: %s';
$lang['email_attachment_unreadable'] = 'এই সংযুক্তিটি খোলা যাচ্ছে না: %s';
$lang['email_no_from'] = '"ফ্রম" হেডার ছাড়া মেইল পাঠানো যায় না।';
$lang['email_no_recipients'] = 'আপনাকে অবশ্যই প্রাপকদের অন্তর্ভুক্ত করতে হবে: To, Cc, or Bcc';
$lang['email_send_failure_phpmail'] = 'পিএইচপি মেইল () ব্যবহার করে ইমেল প্রেরণ করা যাবে না। আপনার সার্ভারটি এই পদ্ধতিটি ব্যবহার করে ইমেল প্রেরণের জন্য কনফিগার করা যাবে না।';
$lang['email_send_failure_sendmail'] = 'পিএইচপি সেন্ডমেইল ব্যবহার করে ইমেল প্রেরণ করা যাবে না। আপনার সার্ভারটি এই পদ্ধতিটি ব্যবহার করে মেইল প্রেরণের জন্য কনফিগার করা যাবে না।';
$lang['email_send_failure_smtp'] = 'পিএইচপি এসএমটিপি ব্যবহার করে মেইল প্রেরণ করা যাবে না। আপনার সার্ভারটি এই পদ্ধতি ব্যবহার করে মেইল প্রেরণের জন্য কনফিগার করা যাবে না।';
$lang['email_sent'] = 'আপনার বার্তা সফলভাবে নিম্নলিখিত প্রোটোকল ব্যবহার করে প্রেরণ করা হয়েছে: %s';
$lang['email_no_socket'] = 'সেন্ডমেইল এর একটি সকেট ওপেন  করা যাচ্ছে না। দয়াকরে সেটিংস পরীক্ষা করুন।';
$lang['email_no_hostname'] = 'আপনি একটি এসএমটিপি  হোস্টনাম নির্দিষ্ট করেন নি।';
$lang['email_smtp_error'] = 'নিম্নলিখিত এসএমটিপি ত্রুটি হয়েছিল: %s';
$lang['email_no_smtp_unpw'] = 'ত্রুটি: আপনাকে অবশ্যই একটি এসএমটিপি ব্যবহারকারী নাম এবং পাসওয়ার্ড নিদিষ্ট করতে হবে।';
$lang['email_failed_smtp_login'] = 'AUTH লগইন কমান্ড প্রেরণে ব্যর্থ। ত্রুটি: %s';
$lang['email_smtp_auth_un'] = 'ব্যবহারকারীর নাম প্রমাণীকরণে ব্যর্থ। ত্রুটি: %s';
$lang['email_smtp_auth_pw'] = 'পাসওয়ার্ড প্রমাণীকরণ করতে ব্যর্থ। ত্রুটি: %s';
$lang['email_smtp_data_failure'] = 'ডেটা প্রেরণে করা যাচ্ছে না:% s';
$lang['email_exit_status'] = 'স্ট্যাটাস কোড থেকে প্রস্থান করুন: %s';

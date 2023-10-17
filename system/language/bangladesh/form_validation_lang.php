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

$lang['form_validation_required']		= 'প্রবেশ করুন {field}.';
$lang['form_validation_isset']			= '{field} ক্ষেত্রের অবশ্যই একটি মান থাকতে হবে।';
$lang['form_validation_valid_email']		= 'দয়াকরে কার্যকর {field} ঠিকানা দিন।';
$lang['form_validation_valid_emails']		= '{field} ক্ষেত্রে অবশ্যই সকল বৈধ ইমেল ঠিকানা থাকতে হবে।';
$lang['form_validation_valid_url']		= '{field} ক্ষেত্রের অবশ্যই একটি বৈধ URL থাকতে হবে।';
$lang['form_validation_valid_ip']		= '{field} ক্ষেত্রের অবশ্যই একটি বৈধ আইপি থাকতে হবে।';
$lang['form_validation_min_length']		= '{field} ক্ষেত্রের দৈর্ঘ্য কমপক্ষে {param} অক্ষর হতে হবে।';
$lang['form_validation_max_length']		= '{field}ক্ষেত্রটি দৈর্ঘ্যে {param} অক্ষরের বেশি হতে পারে না।';
$lang['form_validation_exact_length']		= '{field} ক্ষেত্রটি দৈর্ঘ্যে একই {param} অক্ষর হতে হবে।';
$lang['form_validation_alpha']			= '{field} ক্ষেত্রে কেবল শুধুমাত্র বর্ণানুক্রমিক অক্ষর থাকতে পারে।';
$lang['form_validation_alpha_numeric']		= '{field} ফিল্ডে কেবল আলফা-সংখ্যাযুক্ত অক্ষর থাকতে পারে।';
$lang['form_validation_alpha_numeric_spaces']	= '{field} ক্ষেত্রটিতে কেবল আলফা-সংখ্যাসূচক অক্ষর এবং স্পেস থাকতে পারে।';
$lang['form_validation_alpha_dash']		= '{field} ফিল্ডে কেবল আলফা-সংখ্যাসূচক অক্ষর, আন্ডারস্কোর এবং ড্যাশ থাকতে পারে।';
$lang['form_validation_numeric']		= '{field}ক্ষেত্রটিতে কেবল সংখ্যা থাকতে হবে।';
$lang['form_validation_is_numeric']		= '{field}ফিল্ডে কেবলমাত্র সংখ্যাযুক্ত অক্ষর থাকতে হবে।';
$lang['form_validation_integer']		= '{field} ক্ষেত্রে অবশ্যই একটি পূর্ণসংখ্যা থাকতে হবে।';
$lang['form_validation_regex_match']		= '{field} ক্ষেত্রটি সঠিক বিন্যাসে নেই।';
$lang['form_validation_matches']		= '{field} ক্ষেত্রটি {param}ক্ষেত্রের সাথে মেলে না।';
$lang['form_validation_differs']		= '{field} ক্ষেত্রটি অবশ্যই {param} ক্ষেত্র থেকে পৃথক হওয়া উচিত।';
$lang['form_validation_is_unique'] 		= '{field} ক্ষেত্রে অবশ্যই একটি অনন্য মান থাকতে হবে।';
$lang['form_validation_is_natural']		= '{field} ক্ষেত্রটিতে কেবল সংখ্যা থাকতে হবে।';
$lang['form_validation_is_natural_no_zero']	= '{field} ক্ষেত্রের মধ্যে কেবল সংখ্যা থাকতে হবে এবং এটি শূন্যের চেয়ে বড় হতে হবে।';
$lang['form_validation_decimal']		= '{field} ক্ষেত্রের একটি দশমিক সংখ্যা থাকতে হবে।';
$lang['form_validation_less_than']		= ' {field} ফিল্ডে অবশ্যই {param} এর চেয়ে কম সংখ্যা থাকতে হবে';
$lang['form_validation_less_than_equal_to']	= '{field} ফিল্ডে অবশ্যই {param} এর চেয়ে কম বা সমান সংখ্যা থাকতে হবে';
$lang['form_validation_greater_than']		= ' {field} ফিল্ডে অবশ্যই {param} এর চেয়ে বড় সংখ্যা থাকতে হবে';
$lang['form_validation_greater_than_equal_to']	= '{field} ক্ষেত্র অবশ্যই {param} এর চেয়ে বড় বা সমান সংখ্যা থাকতে হবে';
$lang['form_validation_error_message_not_set']	= 'আপনার ক্ষেত্রের নাম {field} এর সাথে সম্পর্কিত কোনও ত্রুটি বার্তা অ্যাক্সেস করতে অক্ষম';
$lang['form_validation_in_list']		= '{field} ক্ষেত্র অবশ্যই হতে হবে একটি : {param}.';

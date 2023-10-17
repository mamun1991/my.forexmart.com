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

$lang['db_invalid_connection_str'] = 'আপনার জমা দেওয়া সংযোগ স্ট্রিংয়ের ভিত্তিতে ডাটাবেস সেটিংস নির্ধারণ করা যাচ্ছে না।';
$lang['db_unable_to_connect'] = 'প্রদত্ত সেটিংসটি ব্যবহার করে আপনার ডাটাবেস সার্ভারে সংযোগ দেওয়া যাচ্ছে না।';
$lang['db_unable_to_select'] = 'নির্দিষ্ট ডাটাবেস নির্বাচন করা যাচ্ছে না: %s';
$lang['db_unable_to_create'] = 'নির্দিষ্ট ডেটাবেস তৈরি করা যাচ্ছে না: %s';
$lang['db_invalid_query'] = 'আপনার জমা দেওয়া প্রশ্ন বৈধ নয়।';
$lang['db_must_set_table'] = 'আপনার অবশ্যই আপনার অনুসন্ধানের সাথে ব্যবহারযোগ্য ডাটাবেস টেবিলটি সেট করতে হবে।';
$lang['db_must_use_set'] = 'কোনও এন্ট্রি আপডেট করার জন্য আপনাকে অবশ্যই "সেট" পদ্ধতিটি ব্যবহার করতে হবে।';
$lang['db_must_use_index'] = 'ব্যাচের আপডেটের জন্য আপনাকে অবশ্যই একটি ইন্ডেক্স নির্দিষ্ট করতে হবে।';
$lang['db_batch_missing_index'] = 'ব্যাচ আপডেটের জন্য জমা দেওয়া এক বা একাধিক সারি নির্দিষ্ট ইন্ডেক্স অনুপস্থিত।';
$lang['db_must_use_where'] = 'আপডেটগুলো অনুমতি দেওয়া হয় না যতক্ষণ না সেগুলোতে "কোথায়" উল্লেখ থাকে।';
$lang['db_del_must_use_where'] = 'ডিলিট এর অনুমতি দেওয়া হয় না যদি না "কোথায়" বা "লাইক" উল্লেখ থাকে।';
$lang['db_field_param_missing'] = 'প্রয়োজনীয় ক্ষেত্র আনতে প্যারামিটার হিসাবে টেবিলের নাম প্রয়োজন।';
$lang['db_unsupported_function'] = 'আপনি যে ডাটাবেসটি ব্যবহার করছেন তার জন্য এই বৈশিষ্ট্যটি সহজলভ্য নয়।';
$lang['db_transaction_failure'] = 'লেনদেন ব্যর্থ: রোলব্যাক সম্পাদিত।';
$lang['db_unable_to_drop'] = 'নির্দিষ্ট ডেটাবেস ড্রপ করা যাচ্ছে না।';
$lang['db_unsupported_feature'] = 'আপনি যে ডাটাবেস প্ল্যাটফর্মটি ব্যবহার করছেন সেটির বৈশিষ্ট্য সমর্থিত নয়।';
$lang['db_unsupported_compression'] = 'আপনার নির্ধারন করা ফাইল সংকোচনের বিন্যাসটি আপনার সার্ভার দ্বারা সমর্থিত নয়।';
$lang['db_filepath_error'] = 'আপনি যে ফাইলটি জমা দিয়েছেন তাতে তথ্য লেখা যাচ্ছে না।';
$lang['db_invalid_cache_path'] = 'আপনার জমা দেওয়া ক্যাশ পথটি বৈধ বা লেখার যোগ্য নয়।';
$lang['db_table_name_required'] = 'এই কাজের জন্য একটি টেবিলের নাম প্রয়োজন।';
$lang['db_column_name_required'] = 'এই কাজের জন্য একটি কলামের নাম প্রয়োজন।';
$lang['db_column_definition_required'] = 'এই কাজের জন্য একটি কলাম সংজ্ঞা প্রয়োজন।';
$lang['db_unable_to_set_charset'] = 'গ্রাহক সংযোগ অক্ষর সেট নির্ধারন করা যায়নি: %s';
$lang['db_error_heading'] = 'ডাটাবেস সংক্রান্ত একটি ত্রুটি হয়েছে।';


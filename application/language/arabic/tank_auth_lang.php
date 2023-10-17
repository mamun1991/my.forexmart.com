<?php

// Errors
$lang['auth_validation_partner_pass'] = 'الرجاء إدخال كلمة المرور';
$lang['auth_validation_partner_login'] = 'الرجاء إدخال معرف تسجيل الدخول';
$lang['auth_incorrect_password'] = 'الرجاء إدخال كلمة مرور صالحة';
$lang['auth_incorrect_login'] = 'الرجاء إدخال معرف تسجيل دخول صالح';

//$lang['auth_incorrect_password'] = 'كلمة سر خاطئة';
$lang['auth_head'] = 'تسجيل الدخول';
//$lang['auth_incorrect_login'] = 'معرف تسجيل الدخول غير صحيح';
$lang['auth_incorrect_email_or_username'] = 'معرف تسجيل الدخول أو البريد الإلكتروني غير موجود';
$lang['auth_email_in_use'] = 'البريد الإلكتروني مستخدم بالفعل من قبل مستخدم آخر. الرجاء اختيار بريد إلكتروني آخر.';
$lang['auth_username_in_use'] = 'اسم المستخدم موجود بالفعل. يرجى اختيار اسم مستخدم آخر.';
$lang['auth_current_email'] = 'هذا هو بريدك الإلكتروني الحالي';
$lang['auth_incorrect_captcha'] = 'كود التأكيد الخاص بك لا يتطابق مع الكود الموجود في الصورة.';
$lang['auth_captcha_expired'] = 'انتهت صلاحية كود التأكيد الخاص بك. حاول مرة أخرى.';
$lang['auth_account_deactivated'] = 'حسابك تم تعطيله. يرجى الاتصال بفريق الدعم لمزيد من المساعدة.';
$lang['auth_account_blocked'] = 'تم حظر حسابك. يرجى الاتصال بفريق الدعم لمزيد من المساعدة.';

// Notifications
$lang['auth_message_logged_out'] = 'تم تسجيل خروجك بنجاح.';
$lang['auth_message_registration_disabled'] = 'التسجيل معطل.';
$lang['auth_message_registration_completed_1'] = 'لقد سجلت بنجاح. تحقق من عنوان بريدك الإلكتروني لتفعيل حسابك.';
$lang['auth_message_registration_completed_2'] = 'لقد سجلت بنجاح.';
$lang['auth_message_activation_email_sent'] = 'تم إرسال بريد إلكتروني جديد للتنشيط إلى %s. اتبع التعليمات الموجودة في البريد الإلكتروني لتفعيل حسابك.';
$lang['auth_message_activation_completed'] = 'تم تفعيل حسابك بنجاح.';
$lang['auth_message_activation_failed'] = 'كود التفعيل الذي أدخلته هو غير صحيح أو منتهي الصلاحية.';
$lang['auth_message_password_changed'] = 'كلمة المرور الخاصة بك تم تغييرها بنجاح.';
$lang['auth_message_new_password_sent'] = 'تم إرسال بريد إلكتروني يحتوي على تعليمات حول إنشاء كلمة مرور جديدة إليك.';
$lang['auth_message_new_password_activated'] = 'لقد قمت بإعادة تعيين كلمة المرور الخاصة بك بنجاح';
$lang['auth_message_new_password_failed'] = 'مفتاح التنشيط الخاص بك غير صحيح أو منتهي الصلاحية. يرجى التحقق من بريدك الإلكتروني مرة أخرى واتباع التعليمات.';
$lang['auth_message_new_email_sent'] = 'تم إرسال رسالة بريد إلكتروني للتأكيد إلى %s. اتبع التعليمات الموجودة في البريد الإلكتروني لإكمال هذا التغيير في عنوان البريد الإلكتروني.';
$lang['auth_message_new_email_activated'] = 'لقد قمت بتغيير بريدك الإلكتروني بنجاح';
$lang['auth_message_new_email_failed'] = 'مفتاح التنشيط الخاص بك غير صحيح أو منتهي الصلاحية. يرجى التحقق من بريدك الإلكتروني مرة أخرى واتباع التعليمات.';
$lang['auth_message_banned'] = 'أنت محظور.';
$lang['auth_message_unregistered'] = 'لقد تم حذف حسابك...';

// Email subjects
$lang['auth_subject_welcome'] = 'مرحبًا بك في %s!';
$lang['auth_subject_activate'] = 'مرحبًا بك في %s!';
$lang['auth_subject_forgot_password'] = 'نسيت كلمة المرور الخاصة بك في %s?';
$lang['auth_subject_reset_password'] = 'كلمة المرور الجديدة في %s';
$lang['auth_subject_change_email'] = 'عنوان بريدك الإلكتروني الجديد في %s';
$lang['change-detail'] = 'تغيير التفاصيل الشخصية';
$lang['profile-updated'] = 'Profile successfully updated.';
$lang['edit_profile_erro_1'] = 'يرجى استخدام ما لا يقل عن 4 أحرف للاسم.';
$lang['edit_profile_erro_2'] = 'يرجى استخدام ما لا يقل عن 4 أحرف للعنوان.';
$lang['edit_profile_erro_3'] = 'يرجى استخدام ما لا يقل عن 4 أحرف لاسم المدينة.';
$lang['edit_profile_erro_4'] = 'يرجى استخدام ما لا يقل عن 4 أحرف لاسم الولاية.';
$lang['edit_profile_erro_5'] = 'يرجى استخدام ما لا يقل عن حرفين للرمز البريدي.';
$lang['edit_profile_erro_6'] = 'رقم هاتفك غير صحيح. الحد الأدنى المطلوب هو 4 أرقام.';
$lang['edit_profile_erro_7'] = 'الرجاء إدخال بريد إلكتروني صالح.';
$lang['edit_profile_erro_8'] = 'New Password should be one of the combinations: numbers/letters, numbers/symbols, letters/symbols or numbers/letters/symbols with a length of 7 to 15.';
$lang['edit_profile_erro_9'] = '';


/* End of file tank_auth_lang.php */
/* Location: ./application/language/english/tank_auth_lang.php */
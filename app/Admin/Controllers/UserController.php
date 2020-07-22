<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'メンバー';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('password', __('Password'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->tab('ユーザ詳細',function($form) {
            $form->text('name', __('Name'));
            $form->email('email', __('Email'));
            // $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
            // $form->password('password', __('Password'));
            // $form->text('remember_token', __('Remember token'));
            // $form->text('profile.user_id', 'ユーザID')->readonly();
            $form->text('profile.nickname', 'ニックネーム');
            $form->text('profile.zip_code', '郵便番号');
            $form->text('profile.address', '住所');
            $form->text('profile.tel_no', 'TEL');
            $form->text('profile.gender', '性別');
            $form->textarea('profile.self_introduce', '自己紹介')->rows(10);
        })->tab('お気に入り一覧',function($form) {
            $form->hasMany('favorites','',function(Form\NestedForm $nestedForm) {
                $nestedForm->hidden('id');
                $nestedForm->text('user_id','ユーザID')->readonly();
                $nestedForm->text('pref','地域');
                $nestedForm->text('shop_id','店舗ID');
                $nestedForm->text('shop_slug','店舗スラッグ');
                // $nestedForm->number('page','ページ数');
                // $nestedForm->currency('price','価格');
            })->useTable();
        });

        // ->tab('プロフィール',function($form) {
        //     $form->text('profile.user_id', 'ユーザID')->readonly();
        //     $form->text('profile.nickname', 'ニックネーム');
        //     $form->text('profile.zip_code', '郵便番号');
        //     $form->text('profile.address', '住所');
        //     $form->text('profile.tel_no', 'TEL');
        //     $form->text('profile.gender', '性別');
        //     // $form->text('profile.self_introduce', '自己紹介');
        //     $form->textarea('profile.self_introduce', '自己紹介')->rows(10);
        // })

        // $form->tab('氏名',function($form) {
        //     $form->hidden('id');
        //     $form->text('first_name', '名');
        //     $form->text('last_name', '氏');
        // })->tab('本',function($form) {
        //     $form->hasMany('books','BOOK',function(Form\NestedForm $nestedForm) {
        //         $nestedForm->hidden('id');
        //         $nestedForm->text('title','タイトル');
        //         $nestedForm->text('subtitle','サブタイトル');
        //         $nestedForm->number('page','ページ数');
        //         $nestedForm->currency('price','価格');
        //     })->useTable();
        // });

        return $form;
    }
}

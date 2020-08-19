<?php

namespace App\Admin\Controllers;

use App\Inquiry;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InquiryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Inquiry';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Inquiry());

        // $grid->id('created_at')->sortable();

        $grid->column('id', __('Id'));
        $grid->user()->name();
        // $grid->column('user_id', __('User id'));
        $grid->column('title', __('Title'));
        $grid->column('comment', __('Comment'));
        $grid->column('reply_flg', __('Reply flg'));
        $grid->column('status', __('Status'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

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
        $show = new Show(Inquiry::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('title', __('Title'));
        $show->field('comment', __('Comment'));
        $show->field('reply_flg', __('Reply flg'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Inquiry());
        // dd($form);

        $form->display('user_id', __('User id'));
        // dd($form->user()->display('name'));
        // dd($form->belongsTo('user'));
        // $form->belongsTo('user','',function(Form\NestedForm $nestedForm) {
        //     $nestedForm->display('name');
        // });


        $form->text('title', __('Title'));
        $form->textarea('comment', __('Comment'));
        $form->text('reply_flg', __('Reply flg'))->default('on');
        // $form->text('status', __('Status'))->default('new');
        $form->select('status', 'ステータス')->options(['new' => '新規', 'open' => '対応中', 'done' => '対応完了']);
        $form->datetime('deleted_at', '削除')->format('YYYY-MM-DD HH:mm:ss');

        // $form->hasMany('inquiries', function () {
        //     $form->hidden('id');
        //     $form->text('inquiry_id','お問い合せID')->readonly();
        //     $form->text('reply_comment','返信');
        //     // $form->text('company');
        //     // $form->date('start_date');
        //     // $form->date('end_date');
        // });

        $form->hasMany('replies','',function(Form\NestedForm $nestedForm) {
            // dd($nestedForm);
            // $nestedForm->hidden('id');
            $nestedForm->hidden('inquiry_id');
            // $nestedForm->text('inquiry_id','お問い合せID');
            // $nestedForm->text('inquiry_id','お問い合せID')->readonly();
            $nestedForm->textarea('reply_comment','返信');
        });


        // $form->hasMany('inquiries','',function(Form\NestedForm $nestedForm) {
        //     // $nestedForm->hidden('id');
        //     // $nestedForm->text('inquiry_id','お問い合せID')->readonly();
        //     // $nestedForm->text('reply_comment','返信');
        // })->useTable();


        return $form;
    }
}

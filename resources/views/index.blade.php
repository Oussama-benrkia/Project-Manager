@extends('Temp')
@section('cont')
<div class="content">
    <div class="row gy-3 mb-6 justify-content-between">
      <div class="col-md-9 col-auto">
        <h2 class="mb-2 text-1100">Projects Dashboard</h2>
        <h5 class="text-700 fw-semi-bold">Here’s what’s going on at your business right now</h5>
      </div>
      
    </div>
    <div class="row mb-3 gy-6">
      <div class="col-12 col-xxl-2">
        <div class="row align-items-center g-3 g-xxl-0 h-100 align-content-between">
          <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-books text-primary-500"></span>
              <div class="ms-2">
                <div class="d-flex align-items-end">
                  <h2 class="mb-0 me-2">32</h2><span class="fs-1 fw-semi-bold text-900">Projects</span>
                </div>
                <p class="text-800 fs--1 mb-0">Awating processing</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-users-alt text-success-500"></span>
              <div class="ms-2">
                <div class="d-flex align-items-end">
                  <h2 class="mb-0 me-2">94</h2><span class="fs-1 fw-semi-bold text-900">Members</span>
                </div>
                <p class="text-800 fs--1 mb-0">Working hard</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice text-warning-500"></span>
              <div class="ms-2">
                <div class="d-flex align-items-end">
                  <h2 class="mb-0 me-2">23</h2><span class="fs-1 fw-semi-bold text-900">Invoices</span>
                </div>
                <p class="text-800 fs--1 mb-0">Soon to be cleared</p>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      
      
    </div>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-7 pb-3 border-y border-300">
      <div class="row">
        <div class="col-12 col-xl-7 col-xxl-6">
          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <h3 class="text-1100 text-nowrap">Issues Discovered</h3>
              <p class="text-700 mb-md-7">Newly found and yet to be solved</p>
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 fw-bold">Issue type </p>
                <p class="mb-0 fs--1">Total count <span class="fw-bold">257</span></p>
              </div>
              <hr class="bg-200 mb-2 mt-2">
              <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-info-300 bullet-item me-2"></span>
                <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">Product design</p>
                <h5 class="mb-0 text-900">78</h5>
              </div>
              <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-warning-300 bullet-item me-2"></span>
                <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">Development</p>
                <h5 class="mb-0 text-900">63</h5>
              </div>
              <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-danger-300 bullet-item me-2"></span>
                <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">QA &amp; Testing</p>
                <h5 class="mb-0 text-900">56</h5>
              </div>
              <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-success-300 bullet-item me-2"></span>
                <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">Customer queries</p>
                <h5 class="mb-0 text-900">36</h5>
              </div>
              <div class="d-flex align-items-center"><span class="d-inline-block bg-primary bullet-item me-2"></span>
                <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">R &amp; D</p>
                <h5 class="mb-0 text-900">24</h5>
              </div><button class="btn btn-outline-primary mt-5">See Details<svg class="svg-inline--fa fa-angle-right ms-2 fs--2 text-center" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg><!-- <span class="fas fa-angle-right ms-2 fs--2 text-center"></span> Font Awesome fontawesome.com --></button>
            </div>
            <div class="col-12 col-md-6">
              <div class="position-relative mb-sm-4 mb-xl-0">
                <div class="echart-issue-chart" style="min-height: 390px; width: 100%; user-select: none; position: relative;" _echarts_instance_="ec_1689259636582"><div style="position: relative; width: 238px; height: 390px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas style="position: absolute; left: 0px; top: 0px; width: 238px; height: 390px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="297" height="487"></canvas></div><div class="" style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; transition: opacity 0.2s cubic-bezier(0.23, 1, 0.32, 1) 0s, visibility 0.2s cubic-bezier(0.23, 1, 0.32, 1) 0s, transform 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgb(255, 255, 255); border-width: 1px; border-radius: 4px; color: rgb(102, 102, 102); font: 14px / 21px Microsoft YaHei; padding: 10px; top: 0px; left: 0px; transform: translate3d(-110px, 147px, 0px); border-color: rgb(244, 130, 112); pointer-events: none; visibility: hidden; opacity: 0;"><div style="margin: 0px 0 0;line-height:1;"><div style="font-size:14px;color:#666;font-weight:400;line-height:1;">Tasks assigned to me</div><div style="margin: 10px 0 0;line-height:1;"><div style="margin: 0px 0 0;line-height:1;"><span style="display:inline-block;margin-right:4px;border-radius:10px;width:10px;height:10px;background-color:#f48270;"></span><span style="font-size:14px;color:#666;font-weight:400;margin-left:2px">QA &amp; Testing</span><span style="float:right;margin-left:20px;font-size:14px;color:#666;font-weight:900">56</span><div style="clear:both"></div></div><div style="clear:both"></div></div><div style="clear:both"></div></div></div></div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    
    
    
  </div>
  @endsection
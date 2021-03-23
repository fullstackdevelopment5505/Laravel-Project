@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
    @include('SuperadminDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
        @include('SuperadminDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-sm-12">
					<div class="row">	
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-12 from_to_filter">
                                    <form>
                                        <div class="form-group">
                                            <label>Employee ID:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Month:</label>
                                            <select class="form-control">
                                                <option>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                                <option>April</option>
                                                <option>May</option>
                                                <option>June</option>
                                                <option>July</option>
                                                <option>August</option>
                                                <option>September</option>
                                                <option>October</option>
                                                <option>November</option>
                                                <option>December</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Year:</label>
                                            <select class="form-control">
                                                <option>1990</option>
                                                <option>1991</option>
                                                <option>1992</option>
                                                <option>1993</option>
                                                <option>1994</option>
                                                <option>1995</option>
                                                <option>1996</option>
                                                <option>1997</option>
                                                <option>1998</option>
                                                <option>1999</option>
                                                <option>2000</option>
                                                <option>2001</option>
                                                <option>2002</option>
                                                <option>2003</option>
                                                <option>2004</option>
                                                <option>2005</option>
                                                <option>2006</option>
                                                <option>2007</option>
                                                <option>2008</option>
                                                <option>2009</option>
                                                <option>2010</option>
                                                <option>2011</option>
                                                <option>2012</option>
                                                <option>2013</option>
                                                <option>2014</option>
                                                <option>2015</option>
                                                <option>2016</option>
                                                <option>2017</option>
                                                <option>2018</option>
                                                <option>2019</option>
                                                <option>2020</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-success">Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Leave Requests</div>
                                <table class="display responsive nowrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>
                                            <th>11</th>
                                            <th>12</th>
                                            <th>13</th>
                                            <th>14</th>
                                            <th>15</th>
                                            <th>16</th>
                                            <th>17</th>
                                            <th>18</th>
                                            <th>19</th>
                                            <th>20</th>
                                            <th>21</th>
                                            <th>22</th>
                                            <th>23</th>
                                            <th>24</th>
                                            <th>25</th>
                                            <th>26</th>
                                            <th>27</th>
                                            <th>28</th>
                                            <th>29</th>
                                            <th>30</th>
                                            <th>31</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span>John Doe</span> <label class="badge badge-secondary">001</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Mike Miller</span> <label class="badge badge-secondary">005</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Ashley Graham</span> <label class="badge badge-secondary">008</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Leon Kenedy</span> <label class="badge badge-secondary">009</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>John Doe</span> <label class="badge badge-secondary">001</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Mike Miller</span> <label class="badge badge-secondary">005</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Ashley Graham</span> <label class="badge badge-secondary">008</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Leon Kenedy</span> <label class="badge badge-secondary">009</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>John Doe</span> <label class="badge badge-secondary">001</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Mike Miller</span> <label class="badge badge-secondary">005</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Ashley Graham</span> <label class="badge badge-secondary">008</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                        <tr>
                                            <td><span>Leon Kenedy</span> <label class="badge badge-secondary">009</label></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-danger"><i class="fa fa-remove"></i><kbd class="d-none">Absent</kbd></span></td>
                                            <td><span class="badge badge-success"><i class="fa fa-check"></i><kbd class="d-none">Present</kbd></span></td>
                                        </tr>
                                    </tbody>
                                </table>
							</div>
						</div>
                        <!--table end -->
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
        </section>
        <!-- right area end -->
    </div>
    <!-- main div end -->
@endsection
    
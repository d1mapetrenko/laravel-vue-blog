<template>
	<div>
		<div class="box box-primary">
			<div class="box-body">
				<form action="#" @submit.prevent="addPost">
					<div class="form-group">
	                  	<label for="input-title">Title</label>
	                  	<input type="text" class="form-control" id="input-title" v-model="post.title">
	                </div>
	                <div class="form-group">
	                  	<label for="input-body">Body</label>
	                  	<textarea class="form-control" id="input-body" v-model="post.body"></textarea>
	                  	<div class="editor"></div>
	                </div>
	                <button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
		</div>
		<div class="box box-primary">
			<div class="box-body">
				<div class="dataTables_wrapper form-inline dt-bootstrap">
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-bordered table-hover dataTable">
								<thead>
									<tr>
										<td>ID</td>
										<td>Title</td>
										<td>Body</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
									<tr v-for="post in posts">
										<td>{{ post.id }}</td>
										<td>{{ post.title }}</td>
										<td>{{ post.body }}</td>
										<td>
											<a class="btn btn-primary btn-s" href="#" title="Edit" @click.prevent="editPost(post)">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
											<a class="btn btn-danger btn-s" href="#" title="Delete" @click.prevent="deletePost(post.id)">
												<i class="fa fa-trash-o" aria-hidden="true"></i>
											</a>
										</td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="dataTables_paginate paging_simple_numbers">
								<ul class="pagination" style="margin: 0;">
									<li class="paginate_button previous" v-bind:class="[{disabled: !pagination.prev_page}]">
										<a href="#" @click.prevent="fetchPosts(pagination.prev_page)">Previous</a>
									</li>
									<li class="paginate_button next" v-bind:class="[{disabled: !pagination.next_page}]">
										<a href="#" @click.prevent="fetchPosts(pagination.next_page)">Next</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		data: function() {
			return {
				posts: [],
				post: {
					id: '',
					title: '',
					body: ''
				},
				pagination: {},
				edit: false
			}
		},
		methods: {
			fetchPosts(page_uri) {
				page_uri = page_uri || '/api/posts';
				fetch(page_uri)
				.then(res=>res.json())
				.then(res=> {
					this.posts = res.data;
					this.makePagination(res.meta, res.links);
				})
				.catch(err=> console.log(err));
			},
			makePagination(meta, links) {
				var pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					next_page: links.next,
					prev_page: links.prev
				}
				this.pagination = pagination;
			},
			deletePost(id) {
				fetch('/api/post/'+id, { method: 'delete' })
				.then(res=> {
					this.fetchPosts();
				})
				.catch(err=>console.log(err));
			},
			addPost() {
				if (this.edit === false) {
					fetch('/api/posts', {
			          	method: 'post',
			          	body: JSON.stringify(this.post),
			          	headers: {
			            	'content-type': 'application/json'
			          	}
			        })
		          	.then(res => res.json())
		          	.then(data => {
		          		this.post.id = '';
		            	this.post.title = '';
		            	this.post.body = '';
		            	this.fetchPosts();
		          	})
		          	.catch(err => console.log(err));
				} else {
					fetch('/api/posts', {
			          	method: 'put',
			          	body: JSON.stringify(this.post),
			          	headers: {
			            	'content-type': 'application/json'
			          	}
			        })
			        .then(res => res.json())
			        .then(data => {
			            this.post.id = '';
			            this.post.title = '';
			            this.post.body = '';
			            this.edit = false;
			            this.fetchPosts();
			        })
			        .catch(err => console.log(err));
				}
			},
			editPost(post) {
				this.edit = true;
		     	this.post.id = post.id;
		      	this.post.title = post.title;
		      	this.post.body = post.body;
			}
		},
		created() {
			this.fetchPosts();
		}
	}
</script>
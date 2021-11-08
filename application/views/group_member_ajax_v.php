                					<?php $no=1; foreach($member as $d){ ?>
									<tr>
                  						<td><?= $no++; ?></td>
                 			 			<td><?= $d->name?></td>
										<td><?= $d->email?></td>
										<td><?= ucwords($role[$d->id])?></td>
                  						<?php if($data->add_by == $user_now->id){ ?>
										<td>
											<button type="button" class="btn btn-sm btn-icon btn-pure btn-default waves-effect waves-classic" data-toggle="tooltip" data-original-title="Delete">
												<i class="icon md-close" aria-hidden="true"></i>
											</button>
										</td>
                  						<?php } ?>
									</tr>
                					<?php } ?>
								
				
	
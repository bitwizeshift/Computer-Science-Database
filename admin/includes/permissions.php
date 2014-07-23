<?php

class Permission{

	/* Posts */
	const SUBMIT_POST   = 1;  // 2^0
	const PUBLISH_POST  = 2;  // 2^1
	const REVIEW_POST   = 4;  // 2^2
	const DELETE_POST   = 8;  // 2^3
	const LOCK_POST     = 16; // 2^4
	/* Pages */
	const CREATE_PAGE   = 32;  // 2^5
	const DELETE_PAGE   = 64;  // 2^6
	const LOCK_PAGE     = 128; // 2^7
	/* Assets */
	const ADD_ASSET     = 256;  // 2^8
	const MODIFY_ASSET  = 512;  // 2^9
	const DELETE_ASSET  = 1024; // 2^10
	/* Users */
	const ADD_USER      = 2048; // 2^11
	const DELETE_USER   = 4096; // 2^12
	const CHANGE_PERMS  = 8192; // 2^13
	/* Overrides */
	const OVERRIDE_LOCK = 16384; // 2^14
	
	
}
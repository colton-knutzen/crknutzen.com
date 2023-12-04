// JavaScript Document
//arrayTest.js

var assert = require('chai').assert;

describe('Array', function() {
	
	it('should start empty', function() {
		
		var arr = [];
		
		assert.equal(arr.length, 0);
	});
	
	
	it('should have five items', function() {
		
		var arr = [1,2,3,4];
		
		assert.equal(arr.length, 5);
	});
	
	
});

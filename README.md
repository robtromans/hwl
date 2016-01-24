README
======

About
-----------------
I have been recently asked to write two functions (methods) that would belong
to a common utility style class.

The first would calculate the full GTIN check digit for 8,12,13 & 14. The
second would calculate the next day delivery & economy delivery dates from
an assumed, valid date.

Both could only return boolean and the output must be available from the outside
as well as any errors.


Basic Usage
-----------------
The OperationTest class offers a much better overview than what I could explain here,
but a basic usage simply involves creating a new operation object and passing
in the two services. The two main methods used to achieve the goal are;
"calculateAvailableDeliveryDates"
"calculateGTIN"

Once these two have been called then you can access their responses via the various
other methods in the operations class.


Approach
-----------------
Rather than tackle the problem head on and start coding solutions, I adopted
the TDD method (Red, green & refactor). Using this approach I was able to make
sure as much of the code was testable with a strong focus on quality. Writing tests
first ensures that the requirements are always met.

By using dependency injection and decoupling as much of the code as possible, 
it becomes much easier to make changes to one area of the system and not affect 
the other.


Further changes
-----------------
If I was to spend a little more time on this then I would at least move the error
observer into its own class as its currently breaking the single responsibility 
principle. The advantage to this is that it would then be much easier to
have various forms of error tracking such as logging to a DB or sending alerts.

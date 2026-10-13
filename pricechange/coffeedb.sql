create database price;
use price;
create table coffeprice ( name varchar(20), 
                                price decimal(5,2),
                                primary key (name)
                              );

insert into coffeprice values ( 'Just_Java', 
                                      '2' );

insert into coffeprice values ( 'Cafe_au_Lait_single', 
                                      '2' );
insert into coffeprice values ( 'Cafe_au_Lait_double', 
                                      '3' );

insert into coffeprice values ( 'Iced_Cappuccino_sing', 
                                      '4.75' );
insert into coffeprice values ( 'Iced_Cappuccino_doub', 
                                      '5.75     ' );
                                      